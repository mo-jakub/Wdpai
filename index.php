<?php

require 'Routing.php';
require_once 'DatabaseConnector.php';
session_start();

if (!isset($_SESSION['userId']) && isset($_COOKIE['session_token'])) {
    $sessionToken = $_COOKIE['session_token'];
    $userRepository = new UserRepository();

    $user = $userRepository->getUserBySession($sessionToken);

    if ($user) {
        $_SESSION['userId'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $userRepository->checkUserRoleByEmail($user['email']) ?? 'user';
    } else {
        setcookie('session_token', '', time() - 3600, '/');
    }
}

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('dashboard', 'DefaultController');
Router::get('info', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::get('logout', 'SecurityController');
Router::get('entity', 'SearchController');
Router::get('entities', 'SearchController');
Router::get('book', 'BookController');
Router::post('addComment', 'BookController');
Router::post('deleteComment', 'BookController');
Router::get('user', 'UserController');
Router::post('extendSession', 'SecurityController');
Router::get('administration', 'AdminController');
Router::post('addEntity', 'AdminController');
Router::post('deleteEntity', 'AdminController');
Router::post('editEntity', 'AdminController');
Router::post('addBook', 'AdminController');
Router::get('searchBooks', 'SearchController');

Router::run($path);