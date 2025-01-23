<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function dashboard() {
        //TODO: retrive data from database
        //TODO; process
        $connector = DatabaseConnector::getInstance();
        $stmt = $connector->connect()->prepare('SELECT * FROM public.books');
        $stmt->execute();

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $connector->connect()->prepare('SELECT * FROM public.genres');
        $stmt->execute();

        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render("dashboard", ["books" => $books, "genres" => $genres]);
    }

    public function info()
    {
        $this->render('info');
    }

    public function contact()
    {
        $this->render('contact');
    }
}