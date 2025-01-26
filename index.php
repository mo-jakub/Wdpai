<?php

require 'Routing.php';
require_once 'DatabaseConnector.php';

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

Router::run($path);