<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/BookRepository.php';

class DefaultController extends AppController
{
    private BookRepository $bookRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
    }

    public function dashboard(): void
    {
        $booksByGenre = $this->bookRepository->getBooksGroupedByGenre();
        $this->render('dashboard', ['booksByGenre' => $booksByGenre]);
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