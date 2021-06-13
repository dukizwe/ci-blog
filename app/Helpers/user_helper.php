<?php

use Config\Services;

function islogged():bool
{
          $session = Services::session();
          return $session->has('auth');
}

function isAdmin(): bool
{
          return islogged();
}