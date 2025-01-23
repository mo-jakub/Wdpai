<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($genre['name']) ?> - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<main>
    <h1>Genre: <?= htmlspecialchars($genre['name']) ?></h1>

    <div class="books-grid">
        <?php foreach ($books as $book): ?>
            <a href="/book/<?= $book['id'] ?>">
                <div class="book-card">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p><?= htmlspecialchars($book['description']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>