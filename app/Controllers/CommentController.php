<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
use Config\Services;

class CommentController extends BaseController
{

          private $db;

          public function __construct()
          {
                    $this->db = db_connect();
          }

          public function create()
          {
                    helper('post');
                    $postId = $this->request->getVar('post_id');
                    if(!$this->canIComment($postId)) {# verify if you can comment
                              $errors['main'] = 'Can not process the request, max of comments reached';
                              return $this->response->setJSON(compact('errors'));
                    }
                    $errors = $this->getErrors();
                    if(empty($errors)) {
                              $name = $this->request->getVar('name');
                              $body = $this->request->getVar('body');
                              $createQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "INSERT INTO comments(name, post_id, body, created_at, updated_at) VALUES(?, ?, ?, ?, ?)";
                                        return (new Query($db))->setQuery($query);
                              });
                              $createQuery->execute($name, $postId, $body, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
                              $comment = $this->db->query("SELECT name, body, created_at FROM comments WHERE id = {$this->db->insertID()}")->getRow();
                              $comment->name = esc($comment->name);
                              $comment->body = esc($comment->body);
                              $comment->created_at = postDate($comment->created_at);
                              return $this->response->setJSON(compact('comment'));
                    }
                    return $this->response->setJSON(compact('errors'));
          }

          private function getErrors(): array
          {
                    $validation = Services::validation();
                    $validation->withRequest($this->request)->setRules([
                              'name' => 'required|min_length[2]|max_length[20]',
                              'body' => 'required|min_length[2]|max_length[100]',
                              'post_id' => 'required'
                    ])->run();
                    return $validation->getErrors();
          }

          private function canIComment(int $postId): bool
          {
                    $autorityQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM comments WHERE post_id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    if(count($autorityQuery->execute($postId)->getResult()) >= 3) {
                              return false;
                    }
                    return true;
          }
}
