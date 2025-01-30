<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/GenreRepository.php';
require_once __DIR__ . '/../repositories/TagRepository.php';
require_once __DIR__ . '/../repositories/AuthorRepository.php';
require_once __DIR__ . '/../repositories/BookRepository.php';


/**
 * Class SearchController
 *
 * Handles searching and retrieving data for entities (genres, tags, authors)
 * and books in the system.
 */
class SearchController extends AppController
{
    private array $repositories;
    private BookRepository $bookRepository;

    public function __construct()
    {
        parent::__construct();
        $this->repositories = [
            'genre' => new GenreRepository(),
            'tag' => new TagRepository(),
            'author' => new AuthorRepository(),
        ];
        $this->bookRepository = new BookRepository();

    }

    /**
     * Handles displaying details of a specific entity and its associated books.
     *
     * - The type of entity (e.g., genre, tag, author) is specified in the `type` query parameter.
     * - The ID of the entity is retrieved from the `id` query parameter.
     * - Validates the `type` to ensure it exists in `$repositories`.
     * - Retrieves entity details and associated books from the repository.
     *
     * @example /entity?type=genre&id=1
     */
    public function entity(): void
    {
        // Get the `type` and `id` parameters from the query string
        $type = $_GET['type'] ?? '';
        $id = $_GET['id'] ?? '';

        // Check if the type exists in the repositories array
        if (!array_key_exists($type, $this->repositories)) {
            $this->render('errors/ErrorDB'); // Render error page for invalid types
            return;
        }

        $repository = $this->repositories[$type]; // Get the appropriate repository
        $entity = $repository->getEntityById((int)$id); // Fetch entity details by ID
        $books = $repository->getBooksByEntityId((int)$id); // Fetch associated books by entity ID

        // If the entity cannot be found, render an error page
        if (!$entity) {
            $this->render('errors/ErrorDB');
            return;
        }

        // Render the entity view with the entity details and associated books
        $this->render('entity', [
            'type' => $type,
            'entity' => $entity,
            'books' => $books,
        ]);
    }

    /**
     * Handles displaying a list of all entities of a specified type.
     *
     * - The type of entity (e.g., genre, tag, author) is specified in the `type` query parameter.
     * - Validates the `type` to ensure it exists in `$repositories`.
     * - Fetches all entities of the specified type from the repository.
     *
     * @example /entities?type=genre
     */
    public function entities(): void
    {
        // Get the `type` parameter from the query string
        $type = $_GET['type'] ?? '';

        // Check if the type exists in the repositories array
        if (!array_key_exists($type, $this->repositories)) {
            $this->render('errors/ErrorDB'); // Render error page for invalid types
            return;
        }

        $repository = $this->repositories[$type]; // Get the appropriate repository
        $entities = $repository->getAll(); // Fetch all entities of the specified type

        // If no entities are found, render an error page
        if (!$entities) {
            $this->render('errors/ErrorDB');
            return;
        }

        // Render the entities view with the list of entities
        $this->render('entities', [
            'type' => $type,
            'entities' => $entities,
        ]);
    }

    /**
     * Handles searching for books based on a query string.
     *
     * - The query is passed via the `q` query parameter.
     * - If no query is provided, an empty JSON array is returned.
     * - Book data matching the query is fetched from the `BookRepository`.
     * - Returns results in JSON format for AJAX or API requests.
     *
     * @example /searchBooks?q=Harry
     */
    public function searchBooks(): void
    {
        ob_start(); // Start output buffering
        header('Content-Type: application/json'); // Set content type to JSON

        // If the query `q` is empty, return an empty JSON array
        if (empty($_GET['q'])) {
            echo json_encode([]); // Output empty JSON array
            return;
        }

        ob_end_flush(); // Flush the output buffer

        $query = $_GET['q']; // Retrieve the search query from the `q` parameter

        // Fetch books matching the search query using the BookRepository
        $results = $this->bookRepository->searchBooksByQuery($query);

        // Output the search results in JSON format
        echo json_encode($results);
    }
}