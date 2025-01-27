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

    public function addComment(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            header('Location: /login');
            return;
        }

        try {
            $comment = $_POST['comment'];
            $bookId = $_POST['bookId'];

            if (empty($comment))
                return;

            $this->bookRepository->createComment($comment, $bookId, $_SESSION['userId']);
            header("Location: /book/$bookId");
        } catch (Exception $e) {
            $this->render('errors/ErrorDB');
            exit();
        }
    }

    public function deleteComment(): void
    {
        if (!isset($_SESSION['role']) || (($_SESSION['role'] === 'user') && $_POST['username'] !== $_SESSION['username'])) {
            header('Location: /');
            exit();
        }

        $commentId = $_POST['commentId'];

        $this->bookRepository->deleteComment($commentId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}