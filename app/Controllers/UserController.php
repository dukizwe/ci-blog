<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
use Config\Services;

class UserController extends BaseController
{
          public function getReactions(int $postId):array
          {
                    $reactions = [
                              'like' => false,
                              'dislike' => false
                    ];
                    $db = db_connect();
                    $reactionsQuery = $db->prepare(function(BaseConnection $db) {
                              $query = "SELECT vote FROM reactions WHERE ip_address = ? AND post_id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $reaction = $reactionsQuery->execute(Services::request()->getIPAddress(), $postId)->getRow();
                    if($reaction) {
                              if($reaction->vote == 1) {
                                        $reactions['like'] = true;
                              }else if($reaction->vote == -1) {
                                        $reactions['dislike'] = true;
                              }
                    }
                    return $reactions;
          }
}
