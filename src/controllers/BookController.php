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

    public function book($id): void
    {
        $book = $this->bookRepository->getBookById((int) $id);

        if (!$book) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('book', ['book' => $book]);
    }

    public function addComment($bookId): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']))
        {
            $comment = trim($_POST['comment']);
            $userId = $_SESSION['user_id'];
    
            $this->bookRepository->addComment($bookId, $userId, $comment);
        }
    
        header('Location: /book/' . $bookId);
    }
    
}