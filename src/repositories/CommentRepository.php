<?php

class CommentRepository extends Repository
{
    public function createComment(string $comment, int $bookId, int $userId): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.comments (comment, id_user, id_book)
            VALUES (:comment, :id_user, :id_book)
        ');
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':id_book', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect();
    }

    public function deleteComment(int $commentId): void
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.comments WHERE id_comment = :id_comment
        ');
        $stmt->bindParam(':id_comment', $commentId, PDO::PARAM_INT);
        $stmt->execute();
        $this->database->disconnect();
    }

    public function getCommentsByUserId(int $userId): ?array
    {
        $commentsStmt = $this->database->connect()->prepare("
            SELECT c.id_comment, c.id_book, c.comment, c.date, b.title
            FROM public.comments c
            JOIN public.books b ON c.id_book = b.id_book
            WHERE c.id_user = :id
            ORDER BY date DESC
        ");
        $commentsStmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $commentsStmt->execute();

        $this->database->disconnect();
        return $commentsStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}