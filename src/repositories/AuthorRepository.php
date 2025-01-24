<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Author.php';

class AuthorRepository extends Repository
{
    public function getAll(): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id_author AS id, author AS name
            FROM public.authors
            ORDER BY author;
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Author');
    }

    public function getAuthorById(int $id): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id_author, author AS name
            FROM public.authors
            WHERE id_author = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->database->disconnect();
        return $author ?: null;
    }

    public function getBooksByAuthorId(int $id): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT 
                b.id_book AS id,
                b.title,
                b.description
            FROM 
                public.books b
            LEFT JOIN public.book_authors ba ON b.id_book = ba.id_book
            WHERE ba.id_author = :id
        ");

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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