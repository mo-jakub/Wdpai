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

Router::post('register', 'SecurityController');
Router::post('login', 'SecurityController');
Router::post('extendSession', 'SecurityController');
Router::get('logout', 'SecurityController');

Router::get('entities', 'SearchController');
Router::get('entity', 'SearchController');
Router::get('searchBooks', 'SearchController');

Router::get('book', 'BookController');
Router::post('addComment', 'BookController');
Router::post('deleteComment', 'BookController');

Router::get('user', 'UserController');
Router::post('updateInfo', 'UserController');
Router::post('updateEmail', 'UserController');
Router::post('updatePassword', 'UserController');
Router::post('updateUsername', 'UserController');


Router::get('administration', 'AdminController');
Router::post('addEntity', 'AdminController');
Router::post('editEntity', 'AdminController');
Router::post('deleteEntity', 'AdminController');
Router::post('addBook', 'AdminController');
Router::post('editBook', 'AdminController');
Router::post('deleteBook', 'AdminController');

Router::run($path);