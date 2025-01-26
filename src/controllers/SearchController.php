<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/GenreRepository.php';
require_once __DIR__ . '/../repositories/TagRepository.php';
require_once __DIR__ . '/../repositories/AuthorRepository.php';

class SearchController extends AppController
{
    private array $repositories;

    public function __construct()
    {
        parent::__construct();
        $this->repositories = [
            'genre' => new GenreRepository(),
            'tag' => new TagRepository(),
            'author' => new AuthorRepository(),
        ];
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
        $entity = $repository->{"get" . ucfirst($type) . "ById"}((int)$id);
        $books = $repository->{"getBooksBy" . ucfirst($type) . "Id"}((int)$id);

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
}