<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
use CodeIgniter\Database\ResultInterface;
use CodeIgniter\HTTP\URI;
use Config\Services;

class PostsController extends BaseController
{
          private $db;

          protected $request;

          protected $response;

          public const MAX_POSTS = 12;

          public function __construct()
          {
                    $this->db = db_connect();
                    $this->request = Services::request();
                    $this->response = Services::response();
          }

	public function index()
	{
                    helper(['post', 'user']);
                    $posts = self::getAll();
                    return view('posts/index', compact('posts'));
	}

          public function create()
          {
                    $title = $this->request->getVar('title');
                    $body = $this->request->getVar('body');
                    $selectedTags = $this->request->getVar('tags');
                    /**
                     * @var ValidationValidation
                     */
                    $validation = $this->postValidation();
                    if(empty($validation->getErrors())) {
                              $insertPostQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "INSERT INTO posts(title, body, created_at) VALUES(?, ?, ?)";
                                        return (new Query($db))->setQuery($query);
                              });
                              $insertTagQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "INSERT INTO tag_post(post_id, tag_id, created_at) VALUES(?, ?, ?)";
                                        return (new Query($db))->setQuery($query);
                              });
                              $insertPostQuery->execute($title, $body, date('Y-m-d H:i:s'))->getResult();
                              $insertedPost = $this->db->query("SELECT id FROM posts WHERE id = {$this->db->insertID()}")->getRow();
                              foreach($selectedTags as $selectedTag) {
                                        $insertTagQuery->execute($insertedPost->id, $selectedTag, date('Y-m-d H:i:s'));
                              }
                              $success = 'New post added';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('posts.root'));
                    } else {
                              $tags = TagsController::getAll();
                              return view('admin/posts/create', compact('tags', 'validation', 'title', 'body', 'selectedTags'));
                    }
          }

          public function update(int $postId)
          {
                    $title = $this->request->getVar('title');
                    $body = $this->request->getVar('body');
                    $selectedTags = $this->request->getVar('tags');
                    $validation = $this->postValidation();

                    $postQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT * FROM posts WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $post = $postQuery->execute($postId)->getRow();
                    if(!$post) {
                              return view('errors/html/error_404');
                    }
                    if(empty($validation->getErrors())) {
                              $updatePostQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "UPDATE posts SET title = ?, body = ?, updated_at = ? WHERE id = ?";
                                        return (new Query($db))->setQuery($query);
                              });
                              $deleteTagsQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "DELETE FROM tag_post WHERE post_id = ?";
                                        return (new Query($db))->setQuery($query);
                              });
                              $insertTagQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "INSERT INTO tag_post(post_id, tag_id, created_at) VALUES(?, ?, ?)";
                                        return (new Query($db))->setQuery($query);
                              });
                              $updatePostQuery->execute($title, $body, date('Y-m-d H:i:s'), $postId); # update the exsting post
                              $deleteTagsQuery->execute($postId); # delete related tags
                              foreach($selectedTags as $selectedTag) { # then add new tags
                                        $insertTagQuery->execute($postId, $selectedTag, date('Y-m-d H:i:s'));
                              }

                              $success = 'Post edited';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('posts.root'));
                    } else {
                              $tags = TagsController::getAll();
                              return view('admin/posts/edit', compact('tags', 'validation', 'post', 'title', 'body', 'selectedTags'));
                    }
          }

          public function delete(int $postId)
          {
                    $postQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM posts WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $post = $postQuery->execute($postId)->getRow();
                    if($post) {
                              $deleteQuery = $this->db->prepare(function(BaseConnection $db) {
                                        return (new Query($db))->setQuery("DELETE FROM posts WHERE id = ?");
                              });
                              $deleteQuery->execute($postId);
                              $success = 'Post has been deleted';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('posts.root'));
                    }
                    return view('errors/html/error_404');
          }

          public static function getAll(int $tagId = null)
          {
                    $db = db_connect();
                    $page = (int)($_GET['p'] ?? 1);
                    $offset = ($page - 1) * self::MAX_POSTS;
                    if($tagId) {
                              $postsQuery = $db->prepare(function(BaseConnection $db) {
                                        $query = "SELECT p.*
                                                  FROM tag_post AS tp
                                                  JOIN posts AS p ON p.id = tp.post_id
                                                  WHERE tp.tag_id = ? ORDER BY created_at DESC LIMIT ?, ? ";
                                        return (new Query($db))->setQuery($query);
                              });
                              $posts = $postsQuery->execute($tagId, $offset, self::MAX_POSTS)->getResultObject();
                    } else {
                              $postsQuery = $db->prepare(function(BaseConnection $db) {
                                        $query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT ?, ? ";
                                        return (new Query($db))->setQuery($query);
                              });
                              $posts = $postsQuery->execute($offset, self::MAX_POSTS)->getResultObject();
                    }
                    if(empty($posts)) return $posts;
                    $postByIds = [];
                    foreach ($posts as $post) {
                              $postByIds[$post->id] = $post;
                    }
                    $tags = $db->query("SELECT tp.post_id, t.name, t.id
                              FROM tag_post AS tp
                              JOIN tags AS t ON t.id = tp.tag_id
                              WHERE tp.post_id IN (".implode(', ', array_keys($postByIds)).")")->getResultObject();
                    foreach($tags as $tag) {
                              $postByIds[$tag->post_id]->tags[] = $tag;
                    }
                    return $posts;
          }

          public function allByTag(string $tagSlug, int $tagId)
          {
                    helper(['post', 'user']);
                    $posts = self::getAll($tagId);
                    return view('posts/index', compact('posts'));
          }

          public function show(string $slug, int $postId)
          {
                    helper(['post', 'user']);
                    $postQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT * FROM posts WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $post = $postQuery->execute($postId)->getRow();
                    if($post) {
                              if(postSlug($post->title) !== $slug) {
                                        $uri = route_to('posts.show', postSlug($post->title), $postId);
                                        $this->response->redirect($uri, 'auto', 301);
                              }
                              $userController = new UserController();

                              $post->likesCount = $this->likesCount($postId);
                              $post->dislikesCount = $this->dislikesCount($postId);
                              $post->likesPercentage = ($post->likesCount + $post->dislikesCount) === 0 ? 50 : round(($post->likesCount * 100) / ($post->likesCount + $post->dislikesCount));
                              $post->reactions = $userController->getReactions($postId);
                              
                              $tags = $this->postTags($postId);
                              $comments = $this->postComments($postId);
                              return view('posts/show', compact('post', 'tags', 'comments'));
                    }
                    return view('errors/html/error_404');
          }

          public function postTags(int $postId)
          {
                    $tagsQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT t.id, t.name 
                                        FROM tag_post AS tp
                                        JOIN tags AS t ON t.id = tp.tag_id
                                        WHERE tp.post_id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    return $tagsQuery->execute($postId)->getResultObject();
          }

          private function likesCount(int $postId): int
          {
                    $likesCount = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM reactions WHERE post_id = ? AND vote = 1";
                              return (new Query($db))->setQuery($query);
                    })->execute($postId)->getResult();
                    return count($likesCount);
          }

          private function dislikesCount(int $postId): int
          {
                    $dislikesCount = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM reactions WHERE post_id = ? AND vote = -1";
                              return (new Query($db))->setQuery($query);
                    })->execute($postId)->getResult();
                    return count($dislikesCount);
          }

          private function postComments(int $postId)
          {
                    $commentsQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT c.*, u.full_name
                                        FROM comments AS c
                                        JOIN users AS u ON u.id = c.user_id
                                        WHERE c.post_id = ?
                                        ORDER BY c.created_at DESC ";
                              return (new Query($db))->setQuery($query);
                    });
                    return $commentsQuery->execute($postId)->getResultObject();
          }
          private function postValidation()
          {
                    $validation = Services::validation();
                    $validation->withRequest($this->request)->setRules([
                              'title' => 'required|min_length[3]|max_length[50]',
                              'body' => 'required|min_length[10]|max_length[5000]',
                              'tags.0' => 'required|exists[tags.id]',
                              'tags.1' => 'required|exists[tags.id]',
                              'tags.2' => 'required|exists[tags.id]',
                    ], [
                              'tags.0' => [
                                        'required' => 'Select at least 3 tags'
                              ],
                              'tags.1' => [
                                        'required' => 'Select at least 3 tags'
                              ],
                              'tags.2' => [
                                        'required' => 'Select at least 3 tags'
                              ]
                    ])->run();
                    $selectedTags = $this->request->getVar('tags');
                    # check if tags exists in database
                    if(!empty($selectedTags) && count($selectedTags) >= 3) {
                              foreach($selectedTags as $selectedTag) {
                                        $tagsIds[] = $selectedTag;
                              }
                              $query = "SELECT * FROM tags WHERE id IN (".implode(', ', $tagsIds).")";
                              $fetchedTags = $this->db->query($query)->getResultObject();
                              if(count($selectedTags) !== count($fetchedTags)) {
                                        $validation->setError('tags', 'Please select correct tags');
                              }
                    }
                    return $validation;
          }
}
