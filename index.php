<?php

require 'Routing.php';
require_once 'DatabaseConnector.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('dashboard', 'DefaultController');
Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');

Router::run($path);

$connector = new DatabaseConnector();