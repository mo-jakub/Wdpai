<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/BookRepository.php';
require_once __DIR__ . '/../repositories/CommentRepository.php';

class BookController extends AppController
{
    private BookRepository $bookRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
        $this->commentRepository = new CommentRepository();
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

            $this->commentRepository->createComment($comment, $bookId, $_SESSION['userId']);
            header("Location: /book/$bookId");
        } catch (Exception $e) {
            $this->render('errors/ErrorDB');
            exit();
        }
    }

    public function deleteComment(): void
    {
        if (!isset($_SESSION['role']) || (($_SESSION['role'] === 'user') && (int) $_POST['userId'] !== $_SESSION['userId'])) {
            header('Location: /');
            exit();
        }

        $commentId = $_POST['commentId'];

        $this->commentRepository->deleteComment($commentId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}