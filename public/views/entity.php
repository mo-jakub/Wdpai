<?php /** @var string $type */ ?>
<?php /** @var array $entity */ ?>
<?php /** @var array $books */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($entity[0]->getName()) ?> - Power Of Knowledge</title>

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
    <div class="container column">
        <!-- Display the type and name of the entity -->
        <h1><?= ucfirst(htmlspecialchars($type)) ?>: <?= htmlspecialchars($entity[0]->getName()) ?></h1>

        <?php if ($books): ?>
            <!-- Iterate through and display each book associated with the entity -->
            <?php foreach ($books as $book): ?>
                <div class="container border">
                    <!-- Link to the book's details page -->
                    <a class="nav-link book-display" href="/book/<?= $book['id'] ?>">
                        <!-- Display the cover image of the book -->
                        <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-placeholder">
                        <div class="column">
                            <!-- Display the title of the book -->
                            <h3><?= htmlspecialchars($book['title']) ?></h3>
                            <!-- Display a short description of the book -->
                            <p><?= htmlspecialchars($book['description']) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Display a message if no books are associated with the entity -->
            <p>No books available for this <?= htmlspecialchars($type) ?>.</p>
        <?php endif; ?>
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