<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Session\Session;
use Config\Services;
use Config\Validation;

class AuthController extends BaseController
{
          
          /**
           * session
           *
           * @var Session
           */
          private $session;

          public function __construct()
          {
                    $this->session = session();
                    helper(['post', 'user', 'form']);
          }
          public function login()
          {
                    $validation = Services::validation();
                    $validation->withRequest($this->request)->setRules([
                              'username' => 'required',
                              'password' => 'required'
                    ])->run();
                    $errors = $validation->getErrors();
                    $username = $this->request->getVar('username');
                    $password = $this->request->getVar('password');
                    if(empty($errors)) {
                              if($username === 'admin' && $password === 'admin') {
                                        $this->session->set('auth', 1);
                                        return $this->response->redirect("/");
                              } else {
                                        $errors['main'] = 'Incorrect username or password';
                                        return view('user/login', compact('errors', 'username', 'password'));
                              }
                    } else {
                              return view('user/login', compact('validation', 'username', 'password'));
                    }
          }

          public function logout()
          {
                    $this->session->remove('auth');
                    $this->session->destroy();
                    return $this->response->redirect('/');
          }
}
