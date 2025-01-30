<?php /** @var array $booksByGenre */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>

<?php include 'public/views/parts/header.php'; ?>

<main>
<?php foreach($booksByGenre as $genreData): ?>
<div class="border">
    <div class="container">
        <a href="/entity?type=genre&id=<?= $genreData['id'] ?>" class="nav-link">
            <h2><?= htmlspecialchars($genreData['name']) ?></h2>
        </a>
    </div>
    <div class="container">
        <div class="books-grid">
            <?php foreach($genreData['books'] as $book): ?>
                <a href="/book/<?= $book['id'] ?>">
                    <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-placeholder">
                </a>
            <?php endforeach; ?>
            <a href="/entity?type=genre&id=<?= $genreData['id'] ?>" class="nav-link">
                <h2>See More <?= htmlspecialchars($genreData['name']) ?> Books</h2>
            </a>
        </div>
    </div>
</div>
<?php endforeach; ?>
</main>

<?php include 'public/views/parts/footer.php'; ?>

</body>
</html>