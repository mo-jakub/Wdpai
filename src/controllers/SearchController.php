<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/GenreRepository.php';
require_once __DIR__ . '/../repositories/TagRepository.php';
require_once __DIR__ . '/../repositories/AuthorRepository.php';

class SearchController extends AppController
{
    private GenreRepository $genreRepository;
    private TagRepository $tagRepository;
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        parent::__construct();
        $this->genreRepository = new GenreRepository();
        $this->tagRepository = new TagRepository();
        $this->authorRepository = new AuthorRepository();
    }

    public function genre($id): void
    {
        $books = $this->genreRepository->getBooksByGenreId((int) $id);
        $genre = $this->genreRepository->getGenreById((int) $id);
    
        if (!$genre) {
            $this->render('errors/ErrorDB');
            return;
        }
    
        $this->render('entity', [
            'type' => 'genre',
            'entity' => $genre,
            'books' => $books,
        ]);
    }

    public function tag($id): void
    {
        $books = $this->tagRepository->getBooksByTagId((int) $id);
        $tag = $this->tagRepository->getTagById((int) $id);
    
        if (!$tag) {
            $this->render('errors/ErrorDB');
            return;
        }
    
        $this->render('entity', [
            'type' => 'tag',
            'entity' => $tag,
            'books' => $books,
        ]);
    }

    public function author($id): void
    {
        $books = $this->authorRepository->getBooksByAuthorId((int) $id);
        $author = $this->authorRepository->getAuthorById((int) $id);
    
        if (!$author) {
            $this->render('errors/ErrorDB');
            return;
        }
    
        $this->render('entity', [
            'type' => 'author',
            'entity' => $author,
            'books' => $books,
        ]);
    }

    public function genres(): void
    {
        $entities = $this->genreRepository->getAll();

        if (!$entities) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('entities', [
            'type' => 'genre',
            'entities' => $entities,
        ]);
    }

    public function tags(): void
    {
        $entities = $this->tagRepository->getAll();

        if (!$entities) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('entities', [
            'type' => 'tag',
            'entities' => $entities,
        ]);
    }

    public function authors(): void
    {
        $entities = $this->authorRepository->getAll();

        if (!$entities) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('entities', [
            'type' => 'author',
            'entities' => $entities,
        ]);
    }
}