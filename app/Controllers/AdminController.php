<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;

class AdminController extends BaseController
{

          private $db;

          public function __construct()
          {
                    $this->db = db_connect();
                    helper(['post', 'user', 'form']);
          }

          public function createPostGet()
          {
                    $tags = TagsController::getAll();
                    return view('admin/posts/create', compact('tags'));
          }

          public function createPost()
          {
                    return (new PostsController())->create();
          }
          public function editPostGet(int $postId)
          {
                    $postQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT * FROM posts WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $post = $postQuery->execute($postId)->getRow();
                    foreach((new PostsController())->postTags($postId) as $tag) {
                              $post->tags[] = $tag->id;
                    }
                    if($post) {
                              $tags = TagsController::getAll();
                              return view('admin/posts/edit', compact('post', 'tags'));
                    }
                    return view('errors/html/error_404');
          }
          public function editPost(int $postId)
          {
                    return (new PostsController())->update($postId);
          }
          public function deletePost(int $postId)
          {
                    return (new PostsController())->delete($postId);
          }

          # tags
          public function createTagGet()
          {
                    return view('admin/tags/create');
          }

          public function createTag()
          {
                    return (new TagsController())->create();
          }
          public function editTagGet(int $tagId)
          {
                    $tagQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT * FROM tags WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $tag = $tagQuery->execute($tagId)->getRow();
                    if($tag) {
                              return view('admin/tags/edit', compact('tag'));
                    }
                    return view('errors/html/error_404');
          }
          public function editTag(int $tagId)
          {
                    return (new TagsController())->update($tagId);
          }
          public function deleteTag(int $tagId)
          {
                    return (new TagsController())->delete($tagId);
          }
}
