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
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>

<?php include 'public/views/parts/header.php'; ?>

<main>
    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] === $user->getId()): ?>
        <aside class="menu column">
            <h3>Your Account</h3>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>" class="nav-link">Account Main Page</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=editInfo" class="nav-link">Edit Account Information</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=changeUsername" class="nav-link">Change Username</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=changeEmail" class="nav-link">Change Email</a>
            <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>?action=changePassword" class="nav-link">Change Password</a>
        </aside>
    <?php endif; ?>
    <div class="column
        <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] === $user->getId()): ?>
            page-with-menu
        <?php endif; ?>
        ">
        <div class="container column border">
            <h3>Account Information</h3>
            <h4>Username: <?= htmlspecialchars($user->getUsername()) ?></h4>
            <h4>Name: <?= htmlspecialchars($userInfo['name'] ?? 'no name given') ?></h4>
            <h4>Surname: <?= htmlspecialchars($userInfo['surname'] ?? 'no surname given') ?></h4>
            <h4>Summary: <?= htmlspecialchars($userInfo['summary'] ?? 'no summary given') ?></h4>
        </div>
    <div class="container column border">
<?php switch ($action): ?>
<?php case '': ?>
    <?php if (isset($_SESSION['userId']) && $_SESSION['userId'] === $user->getId()): ?>
        <h3>Your comments:</h3>
    <?php else: ?>
        <h3><?= htmlspecialchars($user->getUsername()) ?>'s comments:</h3>
    <?php endif; ?>
    <?php if ($comments): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="container column border">
                <small><?= htmlspecialchars($comment['date']) ?></small>
                <strong>
                    <a href="/user/<?= htmlspecialchars($user->getId()) ?>" class="nav-link">
                        <img src="/public/images/user.svg" alt="" class="logo">
                        <?= htmlspecialchars($user->getUsername()) ?>:
                    </a>
                    <a href="/book/<?= $comment['id_book'] ?>" class="nav-link">
                        <small>
                            <?= htmlspecialchars($comment['title']) ?>
                        </small>
                    </a>
                </strong>
                <?= htmlspecialchars($comment['comment']) ?>
                <?php if (isset($_SESSION['userId'])): ?>
                    <?php if (
                        $_SESSION['userId'] === $user->getId() ||
                        $_SESSION['role'] === 'admin' ||
                        $_SESSION['role'] === 'moderator'
                    ): ?>
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
        <p>No comments yet.</p>
    <?php endif; ?>
<?php break; ?>
<?php case 'editInfo': ?>
    <?php if ($_SESSION['userId'] === $user->getId()): ?>
        <div class="auth-form">
            <h3>Edit Account Information</h3>
            <form method="post" action="/user/updateInfo">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($userInfo['name'] ?? '') ?>">
                <label for="surname">Surname:</label>
                <input type="text" name="surname" id="surname" value="<?= htmlspecialchars($userInfo['surname'] ?? '') ?>">
                <button type="submit">Save</button>
            </form>
        </div>
    <?php endif; ?>
<?php break; ?>
<?php case 'changeEmail': ?>
    <?php if ($_SESSION['userId'] === $user->getId()): ?>
        <div class="auth-form">
            <h3>Change Email</h3>
            <form method="post" action="/user/updateEmail">
                <label for="email">New Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
                <button type="submit">Update Email</button>
            </form>
        </div>
    <?php endif; ?>
<?php break; ?>
<?php case 'changePassword': ?>
    <?php if ($_SESSION['userId'] === $user->getId()): ?>
        <div class="auth-form">
            <h3>Change Password</h3>
            <form method="post" action="/user/updatePassword">
                <label for="currentPassword">Current Password:</label>
                <input type="password" name="currentPassword" id="currentPassword" required>
                <label for="newPassword">New Password:</label>
                <input type="password" name="newPassword" id="newPassword" required>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required>
                <button type="submit">Change Password</button>
            </form>
        </div>
    <?php endif; ?>
<?php break; ?>
<?php case 'changeUsername': ?>
    <?php if ($_SESSION['userId'] === $user->getId()): ?>
        <div class="auth-form">
            <h3>Change Username</h3>
            <form method="post" action="/user/updateUsername">
                <label for="username">New Username:</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user->getUsername()) ?>" required>
                <button type="submit">Update Username</button>
            </form>
        </div>
    <?php endif; ?>
<?php break; ?>
<?php default: ?>
    <p>Invalid action.</p>
<?php endswitch; ?>
    </div>
    </div>
</main>

<?php include 'public/views/parts/footer.php'; ?>

</body>
</html>