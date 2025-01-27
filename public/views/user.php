<?php /** @var User $user */ ?>
<?php /** @var array $comments */ ?>
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

<?php include 'public/partials/header.php'; ?>

<main class="container">
    <div class="container">
        <div class="container column border">
            <h2>username: <?= htmlspecialchars($user->getUsername()) ?></h2>
        </div>
    </div>
    <div class="container column">
        <h3>Comments:</h3>
        <?php if ($comments): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="container column border">
                    <small><?= htmlspecialchars($comment['date']) ?></small>
                    <strong>
                        <a href="/user/<?= htmlspecialchars($user->getId()) ?>" class="nav-link">
                            <img src="/public/images/user.svg" alt="" class="logo">
                            <?= htmlspecialchars($user->getUsername()) ?>:
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
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>
