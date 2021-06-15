<?php

use App\Controllers\AuthController;
use Config\Services;

function islogged():bool
{
          $session = Services::session();
          return $session->has('auth');
}

function isAdmin(): bool
{
          return user() && (int)user()->category_id === 1 && user()->category_name === 'admin';
}

function user()
{
          return AuthController::user();
}