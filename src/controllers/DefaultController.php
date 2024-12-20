<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function dashboard() {
        //TODO: retrive data from database
        //TODO; process
        $connector = new DatabaseConnector();
        $stmt = $connector->connect()->prepare('SELECT * FROM public.books');
        $stmt->execute();

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render("dashboard", ["books" => $books]);
    }
}