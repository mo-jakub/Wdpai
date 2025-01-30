<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/CommentRepository.php';
require_once __DIR__ . '/../repositories/UserInfoRepository.php';

class UserController extends AppController
{
    private UserRepository $userRepository;
    private CommentRepository $commentRepository;
    private UserInfoRepository $userInfoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
        $this->userInfoRepository = new UserInfoRepository();
    }

    public function user($id): void
    {
        $user = $this->userRepository->getUserById((int)$id);
        $userInfo = $this->userInfoRepository->getUserInfoById((int)$id);
        $comments = $this->commentRepository->getCommentsByUserId((int)$id);

        if (!$user) {
            $this->render('errors/ErrorDB');
            return;
        }

        $action = $_GET['action'] ?? '';

        $this->render('user', [
            'user' => $user,
            'userInfo' => $userInfo,
            'comments' => $comments,
            'action' => $action
        ]);
    }

    public function updateInfo(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        $name = $_POST['name'] ?? ' ';
        $surname = $_POST['surname'] ?? ' ';
        $summary = $_POST['summary'] ?? ' ';

        if (!$this->userInfoRepository->getUserInfoById($_SESSION['userId']))
        {
            if ($this->userInfoRepository->addUserInfo($_SESSION['userId'], $name, $surname, $summary))
            {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}");
                return;
            }
        }
        else
        {
            if ($this->userInfoRepository->updateUserInfo($_SESSION['userId'], $name, $surname, $summary))
            {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}");
                return;
            }
        }
        $this->render('errors/ErrorDB');
    }

    public function updateEmail(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        $email = $_POST['email'] ?? null;

        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            if ($this->userRepository->emailExists($email)) {
                $_SESSION['message'] = 'Email is already registered';
                header("Location: /user/{$_SESSION['userId']}?action=changeEmail");
                return;
            }
            if ($this->userRepository->updateEmail($_SESSION['userId'], $email))
            {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}?action=changeEmail");
                return;
            }
            $this->render('errors/ErrorDB');
        }
    }

    public function updatePassword(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        $currentPassword = $_POST['currentPassword'] ?? null;
        $newPassword = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirmPassword'] ?? null;

        if ($newPassword !== $confirmPassword) {
            $_SESSION['message'] = 'Passwords do not match';
            header("Location: /user/{$_SESSION['userId']}?action=changePassword");
            return;
        } else if (strlen($newPassword) < 8) {
            $_SESSION['message'] = 'Password is too short';
            header("Location: /user/{$_SESSION['userId']}?action=changePassword");
            return;
        }

        if ($this->userRepository->verifyPassword($_SESSION['userId'], $currentPassword))
        {
            if ($this->userRepository->updatePassword($_SESSION['userId'], password_hash($newPassword, PASSWORD_BCRYPT)))
            {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}?action=changePassword");
                return;
            }
            $this->render('errors/ErrorDB');
        }
    }

    public function updateUsername(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        $username = $_POST['username'] ?? null;

        if ($username)
        {
            $_SESSION['message'] = 'Invalid username';
            if ($this->userRepository->usernameExists($username))
            {
                $_SESSION['message'] = 'Username is already taken';
                header("Location: /user/{$_SESSION['userId']}?action=changeUsername");
            }
            if ($this->userRepository->updateUsername($_SESSION['userId'], $username))
            {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}?action=changeUsername");
                return;
            }
            $this->render('errors/ErrorDB');
        }
    }
}