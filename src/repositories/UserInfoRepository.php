<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserInfoRepository extends Repository
{
    public function getUserInfoById(int $id): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT name, surname, summary
            FROM public.user_info
            WHERE id_user = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->database->disconnect();
        return $userInfo ?: null;
    }

    public function updateUserInfo(int $userId, ?string $name, ?string $surname, ?string $summary): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
            UPDATE user_info
            SET name = :name, surname = :surname, summary = :summary
            WHERE user_id = :user_id
        ');

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':summary', $summary);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $this->database->disconnect();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error updating user info for userID {$userId} with {$name}, {$surname}: " . $e->getMessage());
            return false;
        }
    }

    public function addUserInfo(int $userId, ?string $name, ?string $surname, ?string $summary): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
                INSERT INTO public.user_info (name, surname, summary, id_user)
                VALUES (:name, :surname, :summary, :user_id)
            ');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':summary', $summary);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $this->database->disconnect();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error inserting user info for userID {$userId} with {$name}, {$surname}: " . $e->getMessage());
            return false;
        }
    }
}