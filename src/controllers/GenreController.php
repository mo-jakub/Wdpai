<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/GenreRepository.php';

class GenreController extends AppController
{
    private GenreRepository $genreRepository;

    public function __construct()
    {
        parent::__construct();
        $this->genreRepository = new GenreRepository();
    }

    public function genre($id): void
    {
        $books = $this->genreRepository->getBooksByGenre((int) $id);
        $genre = $this->genreRepository->getGenreById((int) $id);

        if (!$genre) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('genre', ['books' => $books, 'genre' => $genre]);
    }

    public function genres(): void
    {
        $genres = $this->genreRepository->getAllGenres();

        if (!$genres) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('genres', ['genres' => $genres]);
    }
}