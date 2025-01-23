<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Genre.php';

class GenreRepository extends Repository
{
    public function getAllGenres(): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id_genre AS id, genre AS name
            FROM public.genres
        ");
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Genre');
        $this->database->disconnect();
        return $stmt->fetchAll();
    }

    public function getGenreById(int $id): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id_genre, genre AS name
            FROM public.genres
            WHERE id_genre = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $genre = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->database->disconnect();
        return $genre ?: null;
    }

    public function getBooksByGenre(int $genreId): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT 
                b.id_book AS id,
                b.title,
                b.description
            FROM 
                public.books b
            LEFT JOIN public.book_genres bg ON b.id_book = bg.id_book
            WHERE bg.id_genre = :genreId
        ");

        $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);
        $stmt->execute();

        $books = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $books[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'description' => $row['description']
            ];
        }

        return $books;
    }
}