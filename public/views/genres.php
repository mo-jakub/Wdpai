<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genres - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="public/styles/style.css">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<main>
<div class="book-selection container">
    <div class="books-grid">
        <?php foreach($genres as $genre): ?>
            <a href="/genre/<?= $genre->getId() ?>">
                <img src="https://random.imagecdn.app/700/700" alt="<?= $genre->getName(); ?>" class="book-placeholder">
            </a>
        <?php endforeach; ?>
    </div>
</div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>