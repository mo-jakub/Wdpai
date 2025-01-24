<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/SearchController.php';
require_once 'src/controllers/BookController.php';

class Router {
    public static $routes;

    public static function get($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function run($url)
    {
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        if (!array_key_exists($action, self::$routes)) {
            self::renderError();
            return;
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'dashboard';

        $id = $urlParts[1] ?? '';

        $object->$action($id);
    }

    public static function renderError()
    {
        $errorTemplatePath = 'public/errors/Error404.php';
        
        if (file_exists($errorTemplatePath)) {
            include $errorTemplatePath;
        }
    }
}