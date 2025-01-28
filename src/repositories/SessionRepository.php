<?php

require_once __DIR__ . '/Repository.php';

class SessionRepository extends Repository
{
    public function createSession(int $userId, string $sessionId, string $expirationDate)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.sessions (session_token, id_user, expiration_date)
            VALUES (:session_token, :id_user, :expiration_date)
        ');
        $stmt->bindParam(':session_token', $sessionId, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':expiration_date', $expirationDate, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteSession(string $sessionId)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM public.sessions WHERE session_token = :session_token
        ');
        $stmt->bindParam(':session_token', $sessionId, PDO::PARAM_STR);
        $stmt->execute();

        $this->database->disconnect();
    }

    public function updateSessionExpiration(string $sessionId, string $newExpirationDate) {
        $stmt = $this->database->connect()->prepare('
            UPDATE public.sessions
            SET expiration_date = :expiration_date
            WHERE session_token = :session_token
        ');
        $stmt->bindParam(':session_token', $sessionId, PDO::PARAM_STR);
        $stmt->bindParam(':expiration_date', $newExpirationDate, PDO::PARAM_STR);
        $stmt->execute();

        $this->database->disconnect();
    }

    public function getSessionByToken(string $sessionToken): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.sessions
            WHERE session_token = :session_token
        ');
        $stmt->bindParam(':session_token', $sessionToken, PDO::PARAM_STR);
        $stmt->execute();
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        return $session ?: null;
    }
}