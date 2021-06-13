<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
	public function index()
	{
                    helper(['post', 'user', 'form']);
                    return view('user/login');
	}
}
