<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
use Config\Services;

class UserController extends BaseController
{
          public function __construct()
          {
                    helper(['post', 'user', 'form']);
          }
          public function getReactions(int $postId):array
          {
                    $reactions = [
                              'like' => false,
                              'dislike' => false
                    ];
                    if(!user()) return $reactions;
                    $db = db_connect();
                    $reactionsQuery = $db->prepare(function(BaseConnection $db) {
                              $query = "SELECT vote FROM reactions WHERE user_id = ? AND post_id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    $reaction = $reactionsQuery->execute(user()->id, $postId)->getRow();
                    if($reaction) {
                              if($reaction->vote == 1) {
                                        $reactions['like'] = true;
                              }else if($reaction->vote == -1) {
                                        $reactions['dislike'] = true;
                              }
                    }
                    return $reactions;
          }
	public function login()
	{
                    return view('user/login');
	}
	public function register()
	{
                    return view('user/register');
	}
}
