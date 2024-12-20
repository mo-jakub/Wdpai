<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="public/styles/style.css">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<main>
<?php foreach($genres as $genre): ?>
    <div class="book-selection container">
        <a href="/" class="nav-link">
            <h3><?= $genre["genre"]; ?></h3>
        </a>
        <div class="books-grid">
            <?php foreach($books as $book): ?>
                <img src="https://random.imagecdn.app/700/700" alt=<?= $book["title"]; ?> class="book-placeholder">
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>
</main>

<?php include 'public/partials/header.php'; ?>

</body>
</html>