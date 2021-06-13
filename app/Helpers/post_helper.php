<?php

use App\Controllers\PostsController;
use CodeIgniter\I18n\Time;
use Config\Services;

function postbody(string $body): string
{
          $limit = 200;
          if(mb_strlen($body) <= $limit) {
                    return esc($body);
          }
          return esc(mb_substr($body, 0, $limit)).'...';
          $lastSpace = mb_strpos($body, ' ', $limit);
          return nl2br(esc(mb_substr($body, 0, $lastSpace))).'...';
}
function postTitle(string $title): string
{
          $limit = 25;
          if(mb_strlen($title) <= $limit) {
                    return esc($title);
          }
          return esc(mb_substr($title, 0, $limit)).'...';
}

function postDate(string $date)
{
          $time = Time::parse($date);
          return $time->humanize();
}

function fullDate(string $date)
{
          return (New DateTime($date))->format('l d F Y h:i A');
}

function postSlug(string $title): string
{
          return  strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $title)));
}

function active(string $routeName)
{
          $currentPath = '/'.Services::request()->getUri()->getPath();
          $gettedPath = route_to($routeName);
          if($currentPath === $gettedPath) {
                    return 'active';
          }
          return '';
}

function prevPostsPage(): string
{
          $currentPage = $_GET['p'] ?? 1;
          $prevPage = $currentPage-1;
          $nextUri = Services::request()->uri->setQuery("p=$prevPage");
          return $nextUri;
}

function nextPostsPage(): string
{
          $currentPage = $_GET['p'] ?? 1;
          $nextPage = $currentPage+1;
          $nextUri = Services::request()->uri->setQuery("p=$nextPage");
          return $nextUri;
}

function showPrev(): bool
{
          $currentPage = $_GET['p'] ?? 1;
          return $currentPage > 1;
}
function showNext(): bool
{
          $currentPage = $_GET['p'] ?? 1;
          $allPostsCount = count(db_connect()->query("SELECT * FROM posts")->getResult());
          $pages = ceil($allPostsCount / PostsController::MAX_POSTS);
          return $currentPage < $pages;
}