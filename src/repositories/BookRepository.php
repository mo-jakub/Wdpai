<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Book.php';

class BookRepository extends Repository
{
    public function getBooksGroupedByGenre(): array
    {
        $stmt = $this->database->connect()->prepare("
        WITH ranked_books AS (
            SELECT 
                g.id_genre,
                g.genre,
                b.id_book,
                b.title,
                b.description,
                ROW_NUMBER() OVER (PARTITION BY g.id_genre ORDER BY b.id_book ASC) AS row_number
            FROM 
                public.books b
            INNER JOIN 
                public.book_genres bg ON b.id_book = bg.id_book
            INNER JOIN 
                public.genres g ON bg.id_genre = g.id_genre
        )
        SELECT 
            id_genre,
            genre,
            json_agg(
                json_build_object(
                    'id', id_book,
                    'title', title,
                    'description', description
                )
            ) AS books
        FROM 
            ranked_books
        WHERE 
            row_number <= 6
        GROUP BY 
            id_genre, genre
        ORDER BY 
            genre;
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
            SELECT b.id_book AS id, b.title, b.description 
            FROM public.books b 
            WHERE b.id_book = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Book');

        $book = $stmt->fetch();
        if (!$book) {
            return null;
        }
    
        $tagsStmt = $this->database->connect()->prepare("
            SELECT t.id_tag, t.tag 
            FROM public.book_tags bt 
            LEFT JOIN public.tags t ON bt.id_tag = t.id_tag 
            WHERE bt.id_book = :id
        ");
        $tagsStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $tagsStmt->execute();
        $book->setTags($tagsStmt->fetchAll(PDO::FETCH_ASSOC));


        $authorsStmt = $this->database->connect()->prepare("
            SELECT a.id_author, a.author 
            FROM public.book_authors ba 
            LEFT JOIN public.authors a ON ba.id_author = a.id_author 
            WHERE ba.id_book = :id
        ");
        $authorsStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $authorsStmt->execute();
        $book->setAuthors($authorsStmt->fetchAll(PDO::FETCH_ASSOC));


        $genresStmt = $this->database->connect()->prepare("
            SELECT g.id_genre, g.genre 
            FROM public.book_genres bg 
            LEFT JOIN public.genres g ON bg.id_genre = g.id_genre 
            WHERE bg.id_book = :id
        ");
        $genresStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $genresStmt->execute();
        $book->setGenres($genresStmt->fetchAll(PDO::FETCH_ASSOC));


        $commentsStmt = $this->database->connect()->prepare("
            SELECT c.id_comment, c.comment, c.date, c.id_user, u.username 
            FROM public.comments c 
            LEFT JOIN public.users u ON c.id_user = u.id_user 
            WHERE c.id_book = :id
            ORDER BY c.date DESC
        ");
        $commentsStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $commentsStmt->execute();
        $book->setComments($commentsStmt->fetchAll(PDO::FETCH_ASSOC));
    
        $this->database->disconnect();
        return $book;
    }
}