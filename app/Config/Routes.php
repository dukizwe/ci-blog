<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index', ['as' => 'root']);
$routes->group('posts', function(RouteCollection $routes) {
          $routes->get('/', 'PostsController::index', ['as' => 'posts.root']);
          $routes->addPlaceholder('tagSlug', '[a-z0-9\-]+');
          $routes->get('tag/(:tagSlug)-(:num)', 'PostsController::allByTag/$1/$2', ['as' => 'posts.tag']);
          $routes->addPlaceholder('slug', '[a-z0-9\-]+');
          $routes->get('(:slug)-(:num)', 'PostsController::show/$1/$2', ['as' => 'posts.show']);
});

$routes->get('tags', 'TagsController::index', ['as' => 'tags.root']);

$routes->group('login', function(RouteCollection $routes) {
          $routes->get('/', 'LoginController::index', ['as' => 'login']);
          $routes->post('/', 'AuthController::login');
});
$routes->get('logout', 'AuthController::logout', ['as' => 'logout']);

$routes->group('admin', ['filter' => 'isAdmin'], function(RouteCollection $routes){
          $routes->group('posts', function(RouteCollection $routes) {
                    $routes->get('create', 'AdminController::createPostGet', ['as' => 'posts.create']);
                    $routes->post('create', 'AdminController::createPost');
          
                    $routes->get('edit/(:num)', 'AdminController::editPostGet/$1', ['as' => 'posts.edit']);
                    $routes->post('edit/(:num)', 'AdminController::editPost/$1');

                    $routes->get('delete/(:num)', 'AdminController::deletePost/$1', ['as' => 'posts.delete']);
          });

          $routes->group('tags', function(RouteCollection $routes) {
                    $routes->get('create', 'AdminController::createTagGet', ['as' => 'tags.create']);
                    $routes->post('create', 'AdminController::createTag');
          
                    $routes->get('edit/(:num)', 'AdminController::editTagGet/$1', ['as' => 'tags.edit']);
                    $routes->post('edit/(:num)', 'AdminController::editTag/$1');

                    $routes->get('delete/(:num)', 'AdminController::deleteTag/$1', ['as' => 'tags.delete']);
          });
});

$routes->group('api/posts', function(RouteCollection $routes) {
          $routes->post('like', 'ReactionsController::like');
          $routes->post('dislike', 'ReactionsController::dislike');
});
$routes->post('api/comments',  'CommentController::create');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
