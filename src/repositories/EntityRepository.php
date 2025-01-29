<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/Entity.php';

abstract class EntityRepository extends Repository
{
    protected string $tableName;
    protected string $entityIdField;
    protected string $entityNameField;

    public function getAll(): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT {$this->entityIdField} AS id, {$this->entityNameField} AS name
            FROM public.{$this->tableName}
            ORDER BY {$this->entityNameField};
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Entity');
    }

    public function getEntityById(int $id): ?array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT {$this->entityIdField} AS id, {$this->entityNameField} AS name
            FROM public.{$this->tableName}
            WHERE {$this->entityIdField} = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Entity');

        $entities = $stmt->fetchAll();

        $this->database->disconnect();
        return $entities ?: null;
    }

    public function getBooksByEntityId(int $id): ?array
    {
        $relationTable = 'book_' . $this->tableName;
        $relationIdField = "id_" . $this->entityNameField;

        $stmt = $this->database->connect()->prepare("
            SELECT 
                b.id_book AS id,
                b.title,
                b.description
            FROM 
                public.books b
            LEFT JOIN public.{$relationTable} t ON b.id_book = t.id_book
            WHERE t.{$relationIdField} = :id
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

        return $books ?: null;
    }

    public function deleteEntityById(int $id): bool
    {
        try {
            $stmt = $this->database->connect()->prepare("
                DELETE FROM public.{$this->tableName}
                WHERE {$this->entityIdField} = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->database->disconnect();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting entity with ID {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function addEntity(string $name): bool
    {
        try {
            $stmt = $this->database->connect()->prepare("
                INSERT INTO public.{$this->tableName} ({$this->entityNameField})
                VALUES (:name)
            ");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $this->database->disconnect();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error adding entity with name '{$name}': " . $e->getMessage());
            return false;
        }
    }

    public function editEntity(int $id, string $name): bool
    {
        try {
            $stmt = $this->database->connect()->prepare("
                UPDATE public.{$this->tableName}
                SET {$this->entityNameField} = :name
                WHERE {$this->entityIdField} = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $this->database->disconnect();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error editing entity with ID {$id}: " . $e->getMessage());
            return false;
        }
    }

}