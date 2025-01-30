<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/CommentRepository.php';
require_once __DIR__ . '/../repositories/UserInfoRepository.php';

/**
 * Class UserController
 *
 * Handles user-related functionalities, such as displaying user profiles,
 * updating user information, managing user email, passwords, and usernames.
 */
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

    /**
     * Displays the user profile.
     *
     * - Fetches user details, additional information, and comments by user ID.
     * - Renders an error page if the user is not found.
     *
     * @param int $id The ID of the user to view.
     * @route /user/{id}
     */
    public function user($id): void
    {
        $user = $this->userRepository->getUserById((int)$id); // Get user data by ID.
        $userInfo = $this->userInfoRepository->getUserInfoById((int)$id); // Get additional user info.
        $comments = $this->commentRepository->getCommentsByUserId((int)$id); // Get user's comments.

        // If user data is not found, render an error page.
        if (!$user) {
            $this->render('errors/ErrorDB');
            return;
        }

        // Get any user actions from the query string (if specified).
        $action = $_GET['action'] ?? '';

        // Render the 'user' view with all user-related data.
        $this->render('user', [
            'user' => $user,
            'userInfo' => $userInfo,
            'comments' => $comments,
            'action' => $action
        ]);
    }

    /**
     * Updates user personal information (name, surname, summary).
     *
     * - Requires an active session (user must be logged in).
     * - Adds or updates user information, depending on its presence in the database.
     * - Redirects back to the user profile page after updates.
     *
     */
    public function updateInfo(): void
    {
        // Allow only POST requests and ensure the user is logged in.
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403'); // Render a forbidden access error page.
            return;
        }

        // Get the information from the POST request or set defaults.
        $name = $_POST['name'] ?? ' ';
        $surname = $_POST['surname'] ?? ' ';
        $summary = $_POST['summary'] ?? ' ';

        // Check if the user info already exists.
        if (!$this->userInfoRepository->getUserInfoById($_SESSION['userId'])) {
            // If not, attempt to create new user info.
            if ($this->userInfoRepository->addUserInfo($_SESSION['userId'], $name, $surname, $summary)) {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}");
                return;
            }
        } else {
            // Otherwise, update the user's info.
            if ($this->userInfoRepository->updateUserInfo($_SESSION['userId'], $name, $surname, $summary)) {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}");
                return;
            }
        }

        // Render an error page if database operations fail.
        $this->render('errors/ErrorDB');
    }

    /**
     * Updates the user's email address.
     *
     * - Validates the email format and checks whether the new email already exists.
     * - Updates the email if the validations pass and redirects back with appropriate messages.
     *
     */
    public function updateEmail(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        // Get the new email from the POST data.
        $email = $_POST['email'] ?? null;

        // Validate the email and ensure it does not already exist.
        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($this->userRepository->emailExists($email)) {
                $_SESSION['message'] = 'Email is already registered';
                header("Location: /user/{$_SESSION['userId']}?action=changeEmail");
                return;
            }
            // Update the email if validations pass.
            if ($this->userRepository->updateEmail($_SESSION['userId'], $email)) {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}?action=changeEmail");
                return;
            }
            $this->render('errors/ErrorDB');
        }
    }

    /**
     * Updates the user's password.
     *
     * - Ensures the current password is verified before allowing updates.
     * - Validates the new password meets certain criteria (e.g., length).
     * - Updates the password if validations pass and redirects back with appropriate messages.
     *
     */
    public function updatePassword(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        // Retrieve password-related input from the POST request.
        $currentPassword = $_POST['currentPassword'] ?? null;
        $newPassword = $_POST['password'] ?? null;
        $confirmPassword = $_POST['confirmPassword'] ?? null;

        // Ensure the new password matches the confirmation password.
        if ($newPassword !== $confirmPassword) {
            $_SESSION['message'] = 'Passwords do not match';
            header("Location: /user/{$_SESSION['userId']}?action=changePassword");
            return;
        } elseif (strlen($newPassword) < 8) { // Check for valid password length.
            $_SESSION['message'] = 'Password is too short';
            header("Location: /user/{$_SESSION['userId']}?action=changePassword");
            return;
        }

        // Verify the user's current password before updating.
        if ($this->userRepository->verifyPassword($_SESSION['userId'], $currentPassword)) {
            if ($this->userRepository->updatePassword($_SESSION['userId'], password_hash($newPassword, PASSWORD_BCRYPT))) {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}?action=changePassword");
                return;
            }
            $this->render('errors/ErrorDB');
        }
    }

    /**
     * Updates the user's username.
     *
     * - Ensures the new username does not already exist in the system.
     * - Updates the username if valid and redirects the user appropriately.
     *
     */
    public function updateUsername(): void
    {
        if (!$this->isPost() || !isset($_SESSION['userId'])) {
            $this->render('errors/Error403');
            return;
        }

        // Get the new username from the POST request.
        $username = $_POST['username'] ?? null;

        if ($username) {
            // Set an initial message assuming the username is invalid.
            $_SESSION['message'] = 'Invalid username';
            if ($this->userRepository->usernameExists($username)) {
                $_SESSION['message'] = 'Username is already taken';
                header("Location: /user/{$_SESSION['userId']}?action=changeUsername");
            }

            // Update the username if valid.
            if ($this->userRepository->updateUsername($_SESSION['userId'], $username)) {
                $_SESSION['message'] = 'success';
                header("Location: /user/{$_SESSION['userId']}?action=changeUsername");
                return;
            }
            $this->render('errors/ErrorDB');
        }
    }
}