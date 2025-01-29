<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/GenreRepository.php';
require_once __DIR__ . '/../repositories/TagRepository.php';
require_once __DIR__ . '/../repositories/AuthorRepository.php';
require_once __DIR__ . '/../repositories/BookRepository.php';


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

    public function entity(): void
    {
        $type = $_GET['type'] ?? '';
        $id = $_GET['id'] ?? '';
        if (!array_key_exists($type, $this->repositories)) {
            $this->render('errors/ErrorDB');
            return;
        }

        $repository = $this->repositories[$type];
        $entity = $repository->getEntityById((int)$id);
        $books = $repository->getBooksByEntityId((int)$id);

        if (!$entity) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('entity', [
            'type' => $type,
            'entity' => $entity,
            'books' => $books,
        ]);
    }

    public function entities(): void
    {
        $type = $_GET['type'] ?? '';
        if (!array_key_exists($type, $this->repositories)) {
            $this->render('errors/ErrorDB');
            return;
        }

        $repository = $this->repositories[$type];
        $entities = $repository->getAll();

        if (!$entities) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('entities', [
            'type' => $type,
            'entities' => $entities,
        ]);
    }

    public function searchBooks(): void
    {
        ob_start();
        header('Content-Type: application/json');

        // Example: Empty query handling
        if (empty($_GET['q'])) {
            echo json_encode([]);
            return;
        }

        ob_end_flush();

        $query = $_GET['q'];

        // Example: Fetch Books (Replace with your logic)
        $results = $this->bookRepository->searchBooksByQuery($query);

        echo json_encode($results);
        return;

    }
}