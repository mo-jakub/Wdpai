<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../models/Genre.php';

class BookRepository extends Repository
{
    public function getBooksGroupedByGenre(): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT 
                g.id_genre,
                g.genre,
                json_agg(
                    json_build_object(
                        'id', b.id_book,
                        'title', b.title,
                        'description', b.description
                    )
                ) AS books
            FROM 
                public.books b
            INNER JOIN 
                public.book_genres bg ON b.id_book = bg.id_book
            INNER JOIN 
                public.genres g ON bg.id_genre = g.id_genre
            GROUP BY 
                g.id_genre, g.genre
            ORDER BY 
                g.genre;
        ");

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedBooks = [];
        foreach ($results as $row) {
            $groupedBooks[] = [
                'id' => $row['id_genre'],
                'name' => $row['genre'],
                'books' => json_decode($row['books'], true)
            ];
        }
        
        $this->database->disconnect();
        return $groupedBooks;
    }

    public function getBookById(int $id): ?Book
    {
        $stmt = $this->database->connect()->prepare("
            SELECT 
                b.id_book AS id,
                b.title,
                b.description
            FROM 
                public.books b
            WHERE 
                b.id_book = :id
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book');

        /** @var Book $book */
        $book = $stmt->fetch();

        if (!$book) {
            return null;
        }

        // Pobierz tagi książki
        $tagsStmt = $this->database->connect()->prepare("
            SELECT t.tag
            FROM public.book_tags bt
            LEFT JOIN public.tags t ON bt.id_tag = t.id_tag
            WHERE bt.id_book = :id
        ");
        $tagsStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $tagsStmt->execute();
        $book->setTags($tagsStmt->fetchAll(PDO::FETCH_COLUMN));

        // Pobierz autorów książki
        $authorsStmt = $this->database->connect()->prepare("
            SELECT a.author
            FROM public.book_authors ba
            LEFT JOIN public.authors a ON ba.id_author = a.id_author
            WHERE ba.id_book = :id
        ");
        $authorsStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $authorsStmt->execute();
        $book->setAuthors($authorsStmt->fetchAll(PDO::FETCH_COLUMN));

        // Pobierz gatunki książki
        $genresStmt = $this->database->connect()->prepare("
            SELECT g.genre
            FROM public.book_genres bg
            LEFT JOIN public.genres g ON bg.id_genre = g.id_genre
            WHERE bg.id_book = :id
        ");
        $genresStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $genresStmt->execute();
        $book->setGenres($genresStmt->fetchAll(PDO::FETCH_COLUMN));
        
        $this->database->disconnect();
        return $book;
    }
}