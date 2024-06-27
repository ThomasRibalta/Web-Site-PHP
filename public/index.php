<?php
require '../vendor/autoload.php';
use App\Router;

define("DEBUG_TIME", microtime(true));

$router = new Router(dirname(__DIR__) . '/view');
$router->get('/', '/post/index.php', 'Blog')
        ->get('/posts', '/post/index.php', 'Posts')
        ->get('/posts/[*:slug]-[i:id]', '/post/show.php', 'Post' )
        ->get('/category', '/category/index.php', 'Categories')
        ->get('/category/[*:slug]-[i:id]', '/category/show.php', 'Category')
        ->getPost('/login', '/auth/login.php', 'Login')
        ->get('/logout', '/auth/logout.php', 'Logout')
        ->start();