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

    public function updateUserInfo(int $id, string $name, string $surname, string $summary): void
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.user_info
            SET name = :name, surname = :surname, summary = :summary
            WHERE id_user = :id
        ');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':summary', $summary, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $this->database->disconnect();
    }
}