<?php /** @var User $user */ ?>
<?php /** @var array $userInfo */ ?>
<?php /** @var array $comments */ ?>
<?php /** @var string $action */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user->getUsername()) ?> - Power Of Knowledge</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">

    <!-- Website favicon -->
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>

<?php
/**
 * Include the header section of the site.
 * - This is a reusable view component for site-wide navigation and branding.
 */
include 'public/views/parts/header.php';
?>

<main>
    <?php
    /**
     * Check if the currently logged-in user is viewing their own account.
     * - If true, display a menu for managing account-related actions (e.g., editing details).
     */
    if (isset($_SESSION['userId']) && $_SESSION['userId'] === $user->getId()): ?>
        <aside class="menu column">
            <!-- Account management menu -->
            <h3>Your Account</h3>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>" class="nav-link">Account Main Page</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=editInfo" class="nav-link">Edit Account Information</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=changeUsername" class="nav-link">Change Username</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=changeEmail" class="nav-link">Change Email</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=changePassword" class="nav-link">Change Password</a>
        </aside>
    <?php endif; ?>
    <div class="column
        <?php
    /**
     * Add appropriate styling for pages with or without a sidebar menu.
     */
    if (isset($_SESSION['userId']) && $_SESSION['userId'] === $user->getId()): ?>
            page-with-menu
        <?php endif; ?>
        ">
        <!-- User information section -->
        <div class="container column border">
            <h3>Account Information</h3>
            <h4>Username: <?= htmlspecialchars($user->getUsername()) ?></h4>
            <h4>Name: <?= htmlspecialchars($userInfo['name'] ?? 'no name given') ?></h4>
            <h4>Surname: <?= htmlspecialchars($userInfo['surname'] ?? 'no surname given') ?></h4>
            <h4>Profile Summary: <?= htmlspecialchars($userInfo['summary'] ?? 'no summary given') ?></h4>
        </div>
        <div class="container column border">
            <?php
            /**
             * Display session messages (e.g., success or error messages).
             * - Clear the message after displaying it.
             */
            if (isset($_SESSION['message'])): ?>
                <p><?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']) ?></p>
            <?php endif; ?>

            <?php
            /**
             * Handle account-related actions based on the value of `$action`.
             * - Default action shows user's comments and activity.
             * - Other actions handle profile updates (e.g., username, email, password).
             */
            switch ($action): ?>
<?php case '': ?>
                <!-- Comments section -->
                <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] === $user->getId()): ?>
                <h3>Your comments:</h3>
            <?php else: ?>
                <h3><?= htmlspecialchars($user->getUsername()) ?>'s comments:</h3>
            <?php endif; ?>

                <?php if ($comments): ?>
                <!-- Loop through and display each comment -->
                <?php foreach ($comments as $comment): ?>
                <div class="container column border">
                    <small><?= htmlspecialchars($comment['date']) ?></small>
                    <strong>
                        <!-- Link to user's profile -->
                        <a href="/user/<?= htmlspecialchars($user->getId()) ?>" class="nav-link">
                            <img src="/public/images/user.svg" alt="" class="logo">
                            <?= htmlspecialchars($user->getUsername()) ?>:
                        </a>
                        <!-- Link to the related book -->
                        <a href="/book/<?= $comment['id_book'] ?>" class="nav-link">
                            <small>
                                <?= htmlspecialchars($comment['title']) ?>
                            </small>
                        </a>
                    </strong>
                    <!-- Display the comment content -->
                    <?= htmlspecialchars($comment['comment']) ?>

                    <?php
                    /**
                     * Allow comment deletion for the author, or if the user
                     * is an admin or moderator.
                     */
                    if (isset($_SESSION['userId'])):
                        if (
                            $_SESSION['userId'] === $user->getId() ||
                            $_SESSION['role'] === 'admin' ||
                            $_SESSION['role'] === 'moderator'
                        ): ?>
                            <!-- Comment deletion form -->
                            <form method="post" action="/deleteComment">
                                <input type="hidden" name="commentId" value="<?= $comment['id_comment'] ?>">
                                <input type="hidden" name="userId" value="<?= $user->getId() ?>">
                                <button type="submit">Delete</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <!-- No comments fallback message -->
                <p>No comments yet.</p>
            <?php endif; ?>
                <?php break; ?>

            <?php case 'editInfo': ?>
                <!-- Edit user information form -->
                <?php if ($_SESSION['userId'] === $user->getId()): ?>
                <div class="auth-form">
                    <h3>Edit Account Information</h3>
                    <form method="post" action="/updateInfo">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($userInfo['name'] ?? '') ?>">
                        <label for="surname">Surname:</label>
                        <input type="text" name="surname" id="surname" value="<?= htmlspecialchars($userInfo['surname'] ?? '') ?>">
                        <label for="summary">Profile Summary:</label>
                        <input type="text" name="summary" id="summary" value="<?= htmlspecialchars($userInfo['summary'] ?? '') ?>">
                        <button type="submit">Save</button>
                    </form>
                </div>
            <?php endif; ?>
                <?php break; ?>

            <?php case 'changeEmail': ?>
                <!-- Change email form -->
                <?php if ($_SESSION['userId'] === $user->getId()): ?>
                <div class="auth-form">
                    <h3>Change Email</h3>
                    <form method="post" action="/updateEmail">
                        <label for="email">New Email:</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                        <button type="submit">Update Email</button>
                    </form>
                </div>
            <?php endif; ?>
                <?php break; ?>

            <?php case 'changePassword': ?>
                <!-- Change password form -->
                <?php if ($_SESSION['userId'] === $user->getId()): ?>
                <script src="/public/scripts/registerValidation.js"></script>
                <div class="auth-form">
                    <h3>Change Password</h3>
                    <form method="post" action="/updatePassword">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" name="currentPassword" id="currentPassword" required>
                        <label for="password">New Password:</label>
                        <input type="password" name="password" id="password" required>
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" required>
                        <button type="submit">Change Password</button>
                    </form>
                </div>
            <?php endif; ?>
                <?php break; ?>

            <?php case 'changeUsername': ?>
                <!-- Change username form -->
                <?php if ($_SESSION['userId'] === $user->getId()): ?>
                <div class="auth-form">
                    <h3>Change Username</h3>
                    <form method="post" action="/updateUsername">
                        <label for="username">New Username:</label>
                        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>
                        <button type="submit">Update Username</button>
                    </form>
                </div>
            <?php endif; ?>
                <?php break; ?>

            <?php default: ?>
                <!-- Fallback message for invalid actions -->
                <p>Invalid action.</p>
            <?php endswitch; ?>
        </div>
    </div>
</main>


<?php
/**
 * Include the footer section of the site.
 * - This is a reusable view component for site-wide branding and information.
 */
include 'public/views/parts/footer.php';
?>

</body>
</html>