<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
use CodeIgniter\Database\ResultInterface;
use Config\Services;
use Exception;

class ReactionsController extends BaseController
{

          private $postId = null;

          private $db;

          public function __construct()
          {
                    helper('user');
                    $this->postId = Services::request()->getVar('post_id');
                    $this->db = db_connect();
          }
          
          /**
           * Vérifier qu'une reaction existe      
           *
           * @return ResultInterface|false
           */ 
          private function reactionExists()
          {
                    $reactionQuery = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT * FROM reactions WHERE post_id = ? AND user_id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $reaction = $reactionQuery->execute((int)$this->postId, user()->id)->getRow();
                    return $reaction ?? false;
          }
          public function like()
          {
                    if($this->postId) {
                              $reaction = $this->reactionExists();
                              if($reaction) {
                                        # reaction already exists
                                        if($reaction->vote == 1) {
                                                  # if vote is 1, then remove reaction
                                                  return $this->removeReaction($reaction->id);
                                        } else if($reaction->vote == -1){
                                                  # else if vote is -1 then change it to 1
                                                  return $this->setReaction($reaction->id, 1);
                                        }
                              } else {
                                        # reaction not added yet
                                        # add 1 like
                                       return  $this->addReaction(1);
                              }
                    }
          }
          public function dislike()
          {
                    if($this->postId) {
                              $reaction = $this->reactionExists();
                              if($reaction) {
                                        # reaction already exists
                                        if($reaction->vote == -1) {
                                                  # if vote is -1, then remove reaction
                                                  return $this->removeReaction($reaction->id);
                                        } else if($reaction->vote == 1){
                                                  # else if vote is 1 then change it to -1
                                                  return $this->setReaction($reaction->id, -1);
                                        }
                              } else {
                                        # reaction not added yet
                                        # add 1 dislike
                                       return  $this->addReaction(-1);
                              }
                    }
          }

          private function addReaction(int $vote)
          {
                    $this->db->prepare(function(BaseConnection $db) {
                              $query = "INSERT INTO reactions(post_id, user_id, vote, created_at, updated_at) VALUES(?, ?, ?, ?, ?)";
                              return (new Query($db))->setQuery($query);
                    })->execute((int)$this->postId, user()->id, $vote, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'))->getRowArray();
                    $reactions = array_merge(['like' => true], $this->reactionsCount());
                    return $this->response->setJSON(compact('reactions'));
          }
          private function removeReaction(int $reactionId)
          {
                    $this->db->prepare(function(BaseConnection $db) {
                              $query = 'DELETE FROM reactions WHERE id = ?';
                              return (new Query($db))->setQuery($query);
                    })->execute($reactionId)->getRow();
                    $reactions = array_merge(['like' => false], $this->reactionsCount());
                    return $this->response->setJSON(compact('reactions'));
          }
          private function setReaction(int $reactionId, int $vote)
          {
                    $this->db->prepare(function(BaseConnection $db) {
                              $query = 'UPDATE reactions SET vote = ? WHERE id = ?';
                              return (new Query($db))->setQuery($query);
                    })->execute($vote, $reactionId);
                    $reactions = array_merge(['like' => true], $this->reactionsCount());
                    return $this->response->setJSON(compact('reactions'));
          }

          private function reactionsCount():array
          {
                    $likesCount = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM reactions WHERE post_id = ? AND vote = 1";
                              return (new Query($db))->setQuery($query);
                    })->execute($this->postId)->getResult();
                    $dislikesCount = $this->db->prepare(function(BaseConnection $db) {
                              $query = "SELECT id FROM reactions WHERE post_id = ? AND vote = -1";
                              return (new Query($db))->setQuery($query);
                    })->execute($this->postId)->getResult();
                    return [
                              'likeCount' => count($likesCount),
                              'dislikeCount' => count($dislikesCount),
                    ];
          }
}
