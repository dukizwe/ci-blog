<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
use Config\Services;

class TagsController extends BaseController
{

          protected $request;

          protected $response;

          private $db;

          public function __construct()
          {
                    $this->db = db_connect();
                    helper(['user', 'post']);
                    $this->request = Services::request();
                    $this->response = Services::response();
          }

          public function index()
          {
                    $tags = self::getAll();
                    return view('tags/index', compact('tags'));
          }

          public static function getAll()
          {
                    $db = db_connect();
                    return $db->query("SELECT * FROM tags ORDER BY created_at DESC")->getResultObject();
          }
          public function create()
          {
                    $tagName = $this->request->getVar('tag');
                    $validation = $this->tagValidation();
                    if(empty($validation->getErrors())) {
                              $insertTagQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "INSERT INTO tags(name, created_at) VALUES(?, ?)";
                                        return (new Query($db))->setQuery($query);
                              });
                              $insertTagQuery->execute($tagName, date('Y-m-d H:i:s'))->getResult();
                              $success = 'New tag added';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('tags.root'));
                    } else {
                              return view('admin/tags/create', compact('validation', 'tagName'));
                    }
          }

          public function update(int $tagId)
          {
                    $tagName = $this->request->getVar('tag');
                    $validation = $this->tagValidation();
                    $tagQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT * FROM tags WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $tag = $tagQuery->execute($tagId)->getRow();
                    if(!$tag) {
                              return view('errors/html/error_404');
                    }
                    if(empty($validation->getErrors())) {
                              $updateTagQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "UPDATE tags SET name = ?, updated_at = ? WHERE id = ?";
                                        return (new Query($db))->setQuery($query);
                              });
                              $updateTagQuery->execute($tagName, date('Y-m-d H:i:s'), $tagId); # update the exsting tag
                              $success = 'Tag edited';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('tags.root'));
                    } else {
                              return view('admin/tags/edit', compact('validation', 'tag', 'tagName'));
                    }
          }

          public function delete(int $tagId)
          {
                    $tagQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM tags WHERE id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $tag = $tagQuery->execute($tagId)->getRow();
                    if($tag) {
                              $deleteQuery = $this->db->prepare(function(BaseConnection $db) {
                                        return (new Query($db))->setQuery("DELETE FROM tags WHERE id = ?");
                              });
                              $deleteQuery->execute($tagId);
                              $success = 'Tag has been deleted';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('tags.root'));
                    }
                    return view('errors/html/error_404');
          }
          private function tagValidation()
          {
                    $validation = Services::validation();
                    $validation->withRequest($this->request)->setRules([
                              'tag' => 'required|min_length[2]|max_length[20]',
                    ])->run();
                    return $validation;
          }
}
