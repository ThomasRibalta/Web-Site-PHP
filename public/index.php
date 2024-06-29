<?php
require '../vendor/autoload.php';
use App\Router;

define("DEBUG_TIME", microtime(true));

$router = new Router(dirname(__DIR__) . '/view');
$router->get('/', '/post/index.php', 'Blog')
        ->get('/posts', '/post/index.php', 'Posts')
        ->get('/posts/[*:slug]-[i:id]', '/post/show.php', 'Post' )
        ->getPost('/posts/[*:slug]-[i:id]/edit', '/post/edit.php', 'EditPost')
        ->get('/posts/[*:slug]-[i:id]/delete', '/post/delete.php', 'DeletePost')
        ->get('/category', '/category/index.php', 'Categories')
        ->get('/category/[*:slug]-[i:id]', '/category/show.php', 'Category')
        ->getPost('/login', '/auth/login.php', 'Login')
        ->get('/logout', '/auth/logout.php', 'Logout')
        ->get('/editing', '/post/editing.php', 'Editing')
        ->get('/editing/post', '/post/editing.php', 'EditingP')
        ->getPost('/editing/category', '/category/editing.php', 'EditingC')
        ->start();