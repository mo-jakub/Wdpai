<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/BookRepository.php';
require_once __DIR__ . '/../repositories/GenreRepository.php';
require_once __DIR__ . '/../repositories/TagRepository.php';
require_once __DIR__ . '/../repositories/AuthorRepository.php';

class AdminController extends AppController
{
    private BookRepository $bookRepository;
    private GenreRepository $genreRepository;
    private TagRepository $tagRepository;
    private AuthorRepository $authorRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
        $this->genreRepository = new GenreRepository();
        $this->tagRepository = new TagRepository();
        $this->authorRepository = new AuthorRepository();
    }

    public function administration(): void
    {
        $books = $this->bookRepository->getAllBookDetails();
        $types = [
            [
                'type' => 'author',
                'entities' => $this->authorRepository->getAll()
            ],
            [
                'type' => 'genre',
                'entities' => $this->genreRepository->getAll()
            ],
            [
                'type' => 'tag',
                'entities' => $this->tagRepository->getAll()
            ]
        ];
        $action = $_GET['action'] ?? '';

        $this->render('administration', [
            'books' => $books,
            'types' => $types,
            'action' => $action
        ]);
    }

    public function addBook(): void
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        if ($this->bookRepository->addBook($title, $description))
        {
            $bookId = $this->bookRepository->getBookId($title, $description);
            if (isset($_POST['author']))
            {
                $authors = $_POST['author'];
                foreach ($authors as $author)
                    $this->authorRepository->addRelationBookEntity($bookId, $author);
            }

            if (isset($_POST['genre']))
            {
                $genres = $_POST['genre'];
                foreach ($genres as $genre)
                    $this->genreRepository->addRelationBookEntity($bookId, $genre);
            }

            if (isset($_POST['tag']))
            {
                $tags = $_POST['tag'];
                foreach ($tags as $tag)
                    $this->tagRepository->addRelationBookEntity($bookId, $tag);
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function addEntity(): void
    {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $this->{$type . 'Repository'}->addEntity($name);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function editEntity(): void
    {
        $id = $_POST['id'];
        $name = $_POST['type'];

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function deleteEntity(): void
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $this->{$type . 'Repository'}->deleteEntity($id);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}