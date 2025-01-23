<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/BookRepository.php';

class BookController extends AppController
{
    private BookRepository $bookRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
    }

    public function book($id)
    {
        $book = $this->bookRepository->getBookById((int) $id);

        if (!$book) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('book', ['book' => $book]);
    }
}