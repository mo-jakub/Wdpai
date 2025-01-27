<?php

require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function checkUserRoleByEmail(string $email): ?string
    {
        $stmt = $this->database->connect()->prepare('
            SELECT r.role FROM public.users u
            JOIN public.admins a ON u.id_user = a.id_user
            JOIN public.roles r ON a.id_role = r.id_role
            WHERE u.email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $role = $stmt->fetch(PDO::FETCH_COLUMN);
        return $role ?: null;
    }

    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users (username, email, hashed_password) 
            VALUES (:username, :email, :hashed_password)
        ');
        $username = $user->getUsername();
        $email = $user->getEmail();
        $pass = $user->getHashedPassword();
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':hashed_password', $pass, PDO::PARAM_STR);
        $stmt->execute();
    }

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
    }

    public function getUserBySession(string $sessionId): ?array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.* FROM public.users u
            JOIN public.sessions s ON u.id_user = s.id_user
            WHERE s.session_token = :session_token AND s.expiration_date > NOW()
        ');
        $stmt->bindParam(':session_token', $sessionId, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function usernameExists(string $username): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT 1 FROM public.users WHERE username = :username
    ');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT 1 FROM public.users WHERE email = :email
    ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }
}