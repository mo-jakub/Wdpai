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
        if ($this->isPost()) {
            try {
                $email = $_POST['email'];
                $password = $_POST['password'];
            } catch (Exception $e) {
                $this->render('login',
                    ['message' => 'Incorrect data'
                ]);
                return;
            }

            $user = $this->userRepository->getUserByEmail($email);
            if ($user && password_verify($password, $user['hashed_password'])) {
                $sessionId = bin2hex(random_bytes(32));
                $expirationDate = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');
                $this->userRepository->createSession($user['id_user'], $sessionId, $expirationDate);

                $_SESSION['userId'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];

                $role = $this->userRepository->checkUserRoleByEmail($email);
                switch ($role) {
                    case 'admin':
                        $_SESSION['role'] = 'admin';
                        break;

                    case 'moderator':
                        $_SESSION['role'] = 'moderator';
                        break;

                    default:
                        $_SESSION['role'] = 'user';
                        break;
                }

                setcookie('session_token', $sessionId, time() + 3600, '/');
                header('Location: /');
                return;
            } else {
                $this->render('login', ['message' => 'Email or password is incorrect']);
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
            session_unset();
            session_destroy();
            header('Location: /');
        }
    }

    public function register(): void
    {
        if ($this->isPost()) {
            try {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];
            } catch (Exception $e) {
                $this->render('register',
                    ['message' => 'Incorrect data'
                ]);
                return;
            }

            if ($password !== $confirmPassword) {
                $this->render('register',
                        ['message' => 'Passwords do not match',
                        'default' => ['email' => $email, 'username' => $username]
                    ]);
                return;
            } else if (strlen($password) < 8) {
                $this->render('register',
                        ['message' => 'Password is too short',
                        'default' => ['email' => $email, 'username' => $username]
                    ]);
                return;
            }

            if ($this->userRepository->usernameExists($username)) {
                $this->render('register', [
                    'message' => 'Username is already taken',
                    'default' => ['email' => $email, 'username' => $username]
                ]);
                return;
            }

            if ($this->userRepository->emailExists($email)) {
                $this->render('register', [
                    'message' => 'Email is already registered',
                    'default' => ['email' => $email, 'username' => $username]
                ]);
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user = new User($username, $email, $hashedPassword);

            try {
                $this->userRepository->addUser($user);
            } catch (Exception $e) {
                $this->render('register', [
                    'message' => 'An error occurred while creating the user',
                    'default' => ['email' => $email, 'username' => $username]
                ]);
                return;
            }
            $this->render('login');
            return;
        }
        $this->render('register');
    }
}