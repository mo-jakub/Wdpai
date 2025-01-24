<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Tag.php';

class TagRepository extends Repository
{
    public function getAll(): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id_tag AS id, tag AS name
            FROM public.tags
            ORDER BY tag;
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Tag');
    }

    public function getTagById(int $id): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT id_tag, tag AS name
            FROM public.tags
            WHERE id_tag = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $tag = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->database->disconnect();
        return $tag ?: null;
    }

    public function getBooksByTagId(int $id): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT 
                b.id_book AS id,
                b.title,
                b.description
            FROM 
                public.books b
            LEFT JOIN public.book_tags bt ON b.id_book = bt.id_book
            WHERE bt.id_tag = :id
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