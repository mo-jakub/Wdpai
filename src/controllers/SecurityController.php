<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class SecurityController extends AppController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userRepository->getUserByEmail($email);
            if ($user && password_verify($password, $user['hashed_password'])) {
                $sessionId = bin2hex(random_bytes(32));
                $expirationDate = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');
                $this->userRepository->createSession($user['id_user'], $sessionId, $expirationDate);
                setcookie('session_token', $sessionId, time() + 3600, '/');
                header('Location: /');
                return;
            } else {
                $this->render('login', ['message' => 'Niepoprawny email lub hasło']);
                return;
            }
        }

        $this->render('login');
    }

    public function logout(): void
    {
        if (isset($_COOKIE['session_token'])) {
            $this->userRepository->deleteSession($_COOKIE['session_token']);
            setcookie('session_token', '', time() - 3600, '/');
            header('Location: /');
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($password !== $confirmPassword) {
                $this->render('register', ['message' => 'Hasła się nie zgadzają']);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user = new User($username, $email, $hashedPassword);
            $this->userRepository->addUser($user);

            $this->render('login');
            return;
        }

        $this->render('register');
    }
}