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

<?php include 'public/views/parts/header.php'; ?>

<main>
    <div class="container column">
        <h1><?= ucfirst(htmlspecialchars($type)) ?>: <?= htmlspecialchars($entity[0]->getName()) ?></h1>
        <?php if ($books):
        foreach ($books as $book): ?>
            <div class="container border">
                <a class="nav-link book-display " href="/book/<?= $book['id'] ?>">
                    <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-placeholder">
                    <div class="column">
                        <h3><?= htmlspecialchars($book['title']) ?></h3>
                        <p><?= htmlspecialchars($book['description']) ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; endif; ?>
    </div>
</main>

<?php include 'public/views/parts/footer.php'; ?>

</body>
</html>