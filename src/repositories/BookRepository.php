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

    public function searchBooksByQuery(string $query): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT DISTINCT b.id_book AS id, b.title, b.description, 
            ARRAY_AGG(a.author) AS authors
        FROM public.books b
        LEFT JOIN public.book_authors ba ON b.id_book = ba.id_book
        LEFT JOIN public.authors a ON ba.id_author = a.id_author
        WHERE b.title ILIKE :query OR a.author ILIKE :query
        GROUP BY b.id_book, b.title, b.description
        LIMIT 20
    ");
        $searchTerm = '%' . $query . '%';
        $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect();
        return $books;
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

    function getAllBookDetails(): ?array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id_book AS id, title, description, authors, tags, genres
            FROM public.book_details
        ");
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->database->disconnect();
        return $books;
    }

    public function addBook(string $title, string $description): bool
    {
        try {
            $stmt = $this->database->connect()->prepare("
                INSERT INTO public.books (title, description)
                VALUES (:title, :description)
            ");
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();
            $this->database->disconnect();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error adding book with title '{$title}': " . $e->getMessage());
            return false;
        }
    }

    public function deleteBook(int $bookId): bool
    {
        try {
            $this->database->connect()->beginTransaction();

            // Delete comments referencing the book
            $commentsStmt = $this->database->connect()->prepare("
                DELETE FROM public.comments
                WHERE id_book = :bookId
            ");
            $commentsStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $commentsStmt->execute();

            // Delete book-author relationships
            $authorsStmt = $this->database->connect()->prepare("
                DELETE FROM public.book_authors
                WHERE id_book = :bookId
            ");
            $authorsStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $authorsStmt->execute();

            // Delete book-genre relationships
            $genresStmt = $this->database->connect()->prepare("
                DELETE FROM public.book_genres
                WHERE id_book = :bookId
            ");
            $genresStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $genresStmt->execute();

            // Delete book-tag relationships
            $tagsStmt = $this->database->connect()->prepare("
                DELETE FROM public.book_tags
                WHERE id_book = :bookId
            ");
            $tagsStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $tagsStmt->execute();

            // Delete the book itself
            $bookStmt = $this->database->connect()->prepare("
                DELETE FROM public.books
                WHERE id_book = :bookId
            ");
            $bookStmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
            $bookStmt->execute();

            $this->database->connect()->commit();
            $this->database->disconnect();
            return true;
        } catch (PDOException $e) {
            $this->database->connect()->rollBack();
            error_log("Error deleting book with ID {$bookId}: " . $e->getMessage());
            return false;
        }
    }

    public function getBookId(string $title, string $description): int
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id_book
            FROM public.books
            WHERE title = :title AND description = :description
        ");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_COLUMN);
        $this->database->disconnect();
        return $id;
    }

    public function updateBookRelations(int $bookId, array $authors, array $tags, array $genres): bool
    {
        try {
            $this->database->connect()->beginTransaction();

            // Remove existing authors, tags, and genres
            $this->removeRelations('book_authors', 'id_author', $bookId);
            $this->removeRelations('book_tags', 'id_tag', $bookId);
            $this->removeRelations('book_genres', 'id_genre', $bookId);

            // Insert updated authors
            foreach ($authors as $authorId) {
                $stmt = $this->database->connect()->prepare("
                INSERT INTO public.book_authors (id_book, id_author)
                VALUES (:bookId, :authorId)
            ");
                $stmt->execute(['bookId' => $bookId, 'authorId' => $authorId]);
            }

            // Insert updated tags
            foreach ($tags as $tagId) {
                $stmt = $this->database->connect()->prepare("
                INSERT INTO public.book_tags (id_book, id_tag)
                VALUES (:bookId, :tagId)
            ");
                $stmt->execute(['bookId' => $bookId, 'tagId' => $tagId]);
            }

            // Insert updated genres
            foreach ($genres as $genreId) {
                $stmt = $this->database->connect()->prepare("
                INSERT INTO public.book_genres (id_book, id_genre)
                VALUES (:bookId, :genreId)
            ");
                $stmt->execute(['bookId' => $bookId, 'genreId' => $genreId]);
            }

            $this->database->connect()->commit();
            return true;
        } catch (PDOException $e) {
            $this->database->connect()->rollBack();
            error_log("Error updating book relations: " . $e->getMessage());
            return false;
        }
    }

    private function removeRelations(string $tableName, string $fieldName, int $bookId): void
    {
        $stmt = $this->database->connect()->prepare("
        DELETE FROM public.{$tableName}
        WHERE id_book = :bookId
    ");
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateBookDetails(int $bookId, string $title, string $description): bool
    {
        try {
            $stmt = $this->database->connect()->prepare("
            UPDATE public.books
            SET title = :title, description = :description
            WHERE id_book = :bookId
        ");
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            error_log("Error updating book details: " . $e->getMessage());
            return false;
        }
    }
}