<?php /** @var Book $book */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book->getTitle()) ?> - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>
    
<?php include 'public/partials/header.php'; ?>

<main>
    <div class="book-details">
        <div class="cover">
            <!-- Placeholder for book cover -->
            <img src="https://random.imagecdn.app/700/700" class="book-placeholder">
        </div>
        <div class="details">
            <h2>Title: <?= htmlspecialchars($book->getTitle()) ?></h2>
            <p><strong>Author(s):</strong> <?= implode(', ', array_map('htmlspecialchars', $book->getAuthors())) ?></p>
            <p><strong>Genres:</strong> <?= implode(', ', array_map('htmlspecialchars', $book->getGenres())) ?></p>
            <p><strong>Description:</strong></p>
            <p><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
        </div>
    </div>
    <div class="tags">
        <h3>Tags:</h3>
        <ul>
            <?php foreach ($book->getTags() as $tag): ?>
                <li><?= htmlspecialchars($tag) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>
