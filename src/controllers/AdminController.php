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

    /**
     * Renders the administration view.
     *
     * Fetches all book details, entity types (authors, genres, tags), and
     * renders the 'administration' view with the respective data.
     *
     */
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

    /**
     * Adds a new book to the system with given details including title, description,
     * cover, authors, genres, and tags.
     *
     * @return void
     */
    public function addBook(): void
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $coverPath = null;

        if ($_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverPath = $this->saveCover($_FILES['cover']); // Use the saveCover function
        }

        if (!$coverPath) {
            // Handle the case where the cover upload failed
            error_log("Cover upload failed for adding book: $title");
        }

        if ($this->bookRepository->addBook($title, $description, $coverPath))
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

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Adds a new entity (e.g., author, genre, tag) to the system.
     *
     * @return void
     */
    public function addEntity(): void
    {
        $name = $_POST['name'];
        $type = $_POST['type'];
        if ($this->{$type . 'Repository'}->addEntity($name))
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }
        $this->render('errors/ErrorDB');
    }

    /**
     * Edits an existing entity (e.g., author, genre, tag) in the system.
     *
     * Updates the entity's name based on the provided ID and entity type.
     *
     * @return void
     */
    public function editEntity(): void
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $type = $_POST['type'];

        if ($this->{$type . 'Repository'}->editEntity($id, $name)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }
        $this->render('errors/ErrorDB');
    }

    /**
     * Deletes an entity (e.g., author, genre, tag) from the system.
     *
     * Deletes the entity identified by its ID and type.
     *
     * @return void
     */
    public function deleteEntity(): void
    {
        $id = $_POST['id'];
        $type = $_POST['type'];
        if ($this->{$type . 'Repository'}->deleteEntity($id))
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }
        $this->render('errors/ErrorDB');
    }

    /**
     * Deletes a book from the system based on its ID.
     *
     * @return void
     */
    public function deleteBook(): void
    {
        $id = $_POST['id'];
        if ($this->bookRepository->deleteBook($id))
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        }
        $this->render('errors/ErrorDB');
    }

    /**
     * Edits an existing book in the system.
     *
     * Updates the title, description, cover, and relations (authors, genres, and tags)
     * of the book identified by its ID.
     *
     * @return void
     */
    public function editBook(): void
    {
        $bookId = (int)$_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $authors = $_POST['author'] ?? [];
        $genres = $_POST['genre'] ?? [];
        $tags = $_POST['tag'] ?? [];
        $coverPath = null;

        if ($_FILES['cover']['error'] === UPLOAD_ERR_OK) {
            $coverPath = $this->saveCover($_FILES['cover']); // Use the saveCover function
        }

        if (!$coverPath) {
            // Handle the case where the cover upload failed but still proceed with other updates
            error_log("Cover upload failed for editing book ID: $bookId");
        }

        // Update book details
        if (!$this->bookRepository->updateBookDetails($bookId, $title, $description, $coverPath))
        {
            $this->render('errors/ErrorDB');
            return;
        }

        // Update book relations
        if (!$this->bookRepository->updateBookRelations($bookId, $authors, $tags, $genres))
        {
            $this->render('errors/ErrorDB');
            return;
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    /**
     * Saves the uploaded cover image for a book.
     *
     * Moves the uploaded cover image to the target directory and generates a unique name
     * if the file already exists. Returns the path to the saved file.
     *
     * @param array $coverFile The uploaded cover file details ($_FILES['cover']).
     * @return string|null Returns the file path if succeeded, or null if the upload failed.
     */
    public function saveCover(array $coverFile): ?string
    {
        $targetDir = __DIR__ . '/../../public/images/covers/';

        $fileName = basename($coverFile['name']);
        $targetFile = $targetDir . $fileName;

        // Check if the file already exists
        if (file_exists($targetFile)) {
            return '/public/images/covers/' . $fileName; // Return the existing file's path
        }

        // Generate a unique name if the file does not exist
        $uniqueFileName = uniqid() . '_' . $fileName;
        $uniqueTargetFile = $targetDir . $uniqueFileName;

        if (move_uploaded_file($coverFile['tmp_name'], $uniqueTargetFile)) {
            return '/public/images/covers/' . $uniqueFileName; // Return the newly saved file's path
        }

        // Log an error and return null if the file could not be moved
        error_log("Failed to move uploaded file to: $uniqueTargetFile");
        return null;
    }
}