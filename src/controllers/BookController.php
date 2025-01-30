<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/BookRepository.php';
require_once __DIR__ . '/../repositories/CommentRepository.php';

/**
 * Class BookController
 *
 * Controller for handling book details and comments on books.
 * Provides functionality to view a book, add a comment, and delete a comment.
 */
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

    /**
     * Displays details of a specific book.
     *
     * - Retrieves a book by its ID using the BookRepository.
     * - If the book is not found, renders an error page.
     * - If the book is found, passes the book data to the 'book' view for rendering.
     *
     * @param int $id The ID of the book to display.
     * @route /book/{id}
     */
    public function book($id): void
    {
        // Fetch the book data by ID
        $book = $this->bookRepository->getBookById((int) $id);

        // If the book is not found, render the error page
        if (!$book) {
            $this->render('errors/ErrorDB');
            return;
        }

        // Render the 'book' view with the book data
        $this->render('book', ['book' => $book]);
    }

    /**
     * Adds a comment to a specific book.
     *
     * - Handles only POST requests and requires the user to be logged in.
     * - Validates that the comment content is not empty.
     * - Saves the comment in the database using the CommentRepository.
     * - Redirects back to the book's page after successfully adding the comment.
     *
     */
    public function addComment(): void
    {
        // Ensure the request is POST and the user is logged in
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            header('Location: /login'); // Redirect to the login page if not logged in
            return;
        }

        try {
            // Retrieve the comment and book ID from the POST request
            $comment = $_POST['comment'];
            $bookId = $_POST['bookId'];

            // Check if the comment content is not empty
            if (empty($comment)) {
                return; // Do nothing if the comment is empty
            }

            // Add the comment to the database
            $this->commentRepository->createComment($comment, $bookId, $_SESSION['userId']);

            // Redirect back to the book's page
            header("Location: /book/$bookId");
        } catch (Exception $e) {
            // Render error page if there is an exception (e.g., database issue)
            $this->render('errors/ErrorDB');
            exit();
        }
    }

    /**
     * Deletes a comment from a book.
     *
     * - Requires the user to have sufficient privileges:
     *     - Admins and moderators can delete any comment.
     *     - Regular users can only delete their own comments.
     * - Deletes the comment from the database via the CommentRepository.
     * - Redirects back to the referring page after comment deletion.
     *
     */
    public function deleteComment(): void
    {
        // Ensure the user has the appropriate role or is the owner of the comment
        if (!isset($_SESSION['role']) || (($_SESSION['role'] === 'user') && (int) $_POST['userId'] !== $_SESSION['userId'])) {
            header('Location: /'); // Redirect to the main page if unauthorized
            exit();
        }

        // Retrieve the comment ID from the POST request
        $commentId = $_POST['commentId'];

        // Delete the comment using the CommentRepository
        $this->commentRepository->deleteComment($commentId);

        // Redirect back to the page that referred the user to the deletion action
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}