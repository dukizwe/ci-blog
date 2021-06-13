<?php

namespace App\Controllers;

use App\Models\PostModel;

class Home extends BaseController
{

          private $postModel;

          public function __construct()
          {
                    $this->postModel = new PostModel();
          }
	public function index()
	{
                    helper('user');
                    $posts = PostsController::getAll();
                    helper('post_helper');
		return view('home', compact('posts'));
	}
}
