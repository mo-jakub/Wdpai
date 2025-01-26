<?php /** @var string $type */ ?>
<?php /** @var array $entity */ ?>
<?php /** @var array $books */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($entity['name']) ?> - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<main>
    <div class="container">
        <h1><?= ucfirst(htmlspecialchars($type)) ?>: <?= htmlspecialchars($entity['name']) ?></h1>
    </div>
    <div class="container column">
        <?php foreach ($books as $book): ?>
            <div class="container">
                <a class="nav-link book-display " href="/book/<?= $book['id'] ?>">
                    <img src="https://random.imagecdn.app/700/700" alt="<?= htmlspecialchars($book['title']) ?>" class="book-placeholder">
                    <h3><?= htmlspecialchars($book['title']) ?></h3>
                    <p><?= htmlspecialchars($book['description']) ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>