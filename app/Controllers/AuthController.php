<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Query;
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

          private $db;

          public function __construct()
          {
                    $this->session = session();
                    $this->db = db_connect();
                    helper(['post', 'user', 'form']);
          }

          public function register()
          {
                    $validation = Services::validation();
                    $validation->withRequest($this->request)->setRules([
                              'full_name' => [
                                        'label' => 'Full name',
                                        'rules' => 'required|min_length[2]|max_length[30]'
                              ],
                              'email' => 'required|valid_email|is_unique[users.email]',
                              'password' => 'required|min_length[8]', 
                              'password_confirm' => 'required|matches[password]'
                    ], [
                              'password_confirm' => [
                                        'matches' => 'password does not matches'
                              ]
                    ])->run();
                    $errors = $validation->getErrors();
                    $full_name = $this->request->getVar('full_name');
                    $email = $this->request->getVar('email');
                    $password = $this->request->getVar('password');
                    $password_confirm = $this->request->getVar('password_confirm');
                    if(empty($errors)) {
                              $insertQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "INSERT INTO users(category_id, full_name, email, password, created_at) VALUES(?, ?, ?, ?, ?)";
                                        return (new Query($db))->setQuery($query);
                              });
                              $insertQuery->execute(2, $full_name, $email, sha1($password), date('Y-m-d H:i:s'));
                              $this->session->set('auth', $this->db->insertID());

                              $success = 'Your account has been created';
                              session()->setFlashdata('success', $success);
                              return $this->response->redirect(route_to('posts.root'));
                    } else {
                              return view('user/register', compact('validation', 'full_name', 'email', 'password', 'password_confirm'));
                    }
          }

          public function login()
          {
                    $validation = Services::validation();
                    $validation->withRequest($this->request)->setRules([
                              'email' => 'required|valid_email',
                              'password' => 'required'
                    ])->run();
                    $errors = $validation->getErrors();
                    $email = $this->request->getVar('email');
                    $password = $this->request->getVar('password');
                    if(empty($errors)) {
                              $userQuery = $this->db->prepare(function(BaseConnection $db) {
                                        $query = "SELECT * FROM users WHERE email = ?";
                                        return (new Query($db))->setQuery($query);
                              });
                              $user = $userQuery->execute($email)->getRow();
                              if($user && sha1($password) === $user->password) {
                                        $this->session->set('auth', $user->id);
                                        return $this->response->redirect("/");
                              } else {
                                        $errors['main'] = 'Incorrect username or password';
                                        return view('user/login', compact('errors', 'email', 'password'));
                              }
                    } else {
                              return view('user/login', compact('validation', 'email', 'password'));
                    }
          }

          public function logout()
          {
                    $this->session->remove('auth');
                    $this->session->destroy();
                    return $this->response->redirect('/');
          }

          public static function user()
          {
                    $session = Services::session();
                    $userQuery = db_connect()->prepare(function(BaseConnection $db) {
                              $query = "SELECT u.*, uc.name AS category_name, uc.id AS category_id
                                        FROM users AS u
                                        JOIN users_categories AS uc ON uc.id = u.category_id
                                        WHERE u.id = ?";
                              return (new Query($db))->setQuery($query);
                    });
                    if($session->get('auth')) {
                              return $userQuery->execute($session->get('auth'))->getRow();
                    }
                    return null;
          }
}
