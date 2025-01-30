<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/BookRepository.php';

/**
 * Class DefaultController
 *
 * The DefaultController is responsible for rendering the application's main dashboard and informational pages.
 * It serves as a default controller for handling entry-level routes of the application.
 */
class DefaultController extends AppController
{
    private BookRepository $bookRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
    }

    /**
     * Displays the dashboard with books grouped by genres.
     *
     * - Fetches the books grouped by genre using the `BookRepository`.
     * - Passes the data to the 'dashboard' view for rendering.
     *
     * @route /dashboard
     */
    public function dashboard(): void
    {
        // Fetch books classified by genre from the repository
        $booksByGenre = $this->bookRepository->getBooksGroupedByGenre();

        // Render the 'dashboard' view and pass the data (books grouped by genre)
        $this->render('dashboard', ['booksByGenre' => $booksByGenre]);
    }

    /**
     * Displays informational pages (e.g., "About Us", "Contact Us").
     *
     * - Determines the page to load based on the `page` query parameter (default is "about").
     * - Passes the page name to the 'info' view for dynamic rendering.
     *
     * @route /info?page=about
     * @example /info?page=contact
     */
    public function info()
    {
        // Get the `page` parameter from the query string; default to 'about'
        $page = $_GET['page'] ?? 'about';

        // Render the 'info' view with the selected page information
        $this->render('info', ['page' => $page]);
    }
}