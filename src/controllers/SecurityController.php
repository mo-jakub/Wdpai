<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/SessionRepository.php';

/**
 * Class SecurityController
 *
 * Handles user authentication, registration, session management, and logout functionality.
 */
class SecurityController extends AppController
{
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->sessionRepository = new SessionRepository();
    }

    /**
     * Renders the login page or handles user login logic.
     *
     * - Validates the POST request containing user credentials.
     * - Verifies the user's email and password.
     * - Creates a secure session for authenticated users.
     * - Sets the user's role (admin, moderator, or default user).
     * - Redirects to the homepage upon successful login.
     */
    public function login(): void
    {
        if ($this->isPost()) {
            try {
                // Retrieving login details from a POST request
                $email = $_POST['email'];
                $password = $_POST['password'];
            } catch (Exception $e) {
                // Render login page with error message for invalid input
                $this->render('login', [
                    'message' => 'Incorrect data'
                ]);
                return;
            }

            $user = $this->userRepository->getUserByEmail($email);
            if ($user && password_verify($password, $user->getHashedPassword())) {
                // Creates a secure session and stores user details in session/cookies
                $sessionId = bin2hex(random_bytes(32)); // Secure 32-byte session token
                $expirationDate = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');

                $this->sessionRepository->createSession($user->getId(), $sessionId, $expirationDate);

                // Sets session variables for the user
                $_SESSION['userId'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();

                // Determine the user's role
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

                // Set a secure HTTP cookie for the session token
                setcookie('session_token', $sessionId, time() + 3600, '/');

                // Redirect to homepage
                header('Location: /');
                return;
            } else {
                // Render login page with error message for invalid credentials
                $this->render('login', [
                    'message' => 'Email or password is incorrect'
                ]);
                return;
            }
        }

        $this->render('login'); // Default render login page
    }

    /**
     * Logs out the current user by clearing session and cookies.
     *
     * - Deletes an active session from the database.
     * - Destroys browser session and session token cookie.
     */
    public function logout(): void
    {
        if (isset($_COOKIE['session_token'])) {
            $this->sessionRepository->deleteSession($_COOKIE['session_token']);
            setcookie('session_token', '', time() - 3600, '/');
            session_unset();
            session_destroy();
            header('Location: /');
        }
    }

    /**
     * Handles user registration by validating input data and creating a new user account.
     *
     * - Validates username, email, and passwords.
     * - Ensures the email and username are unique before registering the user.
     * - Hashes the password and stores the user in the database.
     */
    public function register(): void
    {
        if ($this->isPost()) {
            try {
                // Collecting user registration data
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];
            } catch (Exception $e) {
                $this->render('register', [
                    'message' => 'Incorrect data'
                ]);
                return;
            }

            // Validating registration inputs
            if ($password !== $confirmPassword) {
                $this->render('register', [
                    'message' => 'Passwords do not match',
                    'default' => ['email' => $email, 'username' => $username]
                ]);
                return;
            } else if (strlen($password) < 8) {
                $this->render('register', [
                    'message' => 'Password is too short',
                    'default' => ['email' => $email, 'username' => $username]
                ]);
                return;
            }

            // Checking if the username or email already exists
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

            // Creating a new user
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setHashedPassword($hashedPassword);

            try {
                $this->userRepository->addUser($user);
            } catch (Exception $e) {
                // Render error message upon a failure during user creation
                $this->render('register', [
                    'message' => 'An error occurred while creating the user',
                    'default' => ['email' => $email, 'username' => $username]
                ]);
                return;
            }
            $this->render('login'); // On successful registration, render login page
            return;
        }
        $this->render('register'); // Default rendering of the registration page
    }

    /**
     * Extends the active session expiration time.
     *
     * - Verifies that the session is valid and associated with a logged-in user.
     * - Updates the session expiration time in the database and session cookie.
     */
    public function extendSession(): void
    {
        if (isset($_SESSION['userId']) && isset($_COOKIE['session_token'])) {
            $sessionToken = $_COOKIE['session_token'];
            $session = $this->sessionRepository->getSessionByToken($sessionToken);

            if ($session && new DateTime() < new DateTime($session['expiration_date'])) {
                $newExpirationDate = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');
                $this->sessionRepository->updateSessionExpiration($sessionToken, $newExpirationDate);

                setcookie('session_token', $sessionToken, time() + 3600, '/');
            }
        }
    }
}