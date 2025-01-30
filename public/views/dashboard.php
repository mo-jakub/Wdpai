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

<?php
/**
 * Include the header section of the site.
 * - This is a reusable view component for site-wide navigation and branding.
 */
include 'public/views/parts/header.php';
?>

<main>
    <?php
    /**
     * Loop through each genre in the $booksByGenre array to render its books.
     *
     * @var array $genreData Each element represents a genre, containing the genre's ID, name, and associated books.
     */
    foreach ($booksByGenre as $genreData):
        ?>
        <div class="border">
            <div class="container">
                <?php
                /**
                 * Render the genre name with a link to its detail page.
                 * Uses `htmlspecialchars()` to escape data for secure output.
                 */
                ?>
                <a href="/entity?type=genre&id=<?= $genreData['id'] ?>" class="nav-link">
                    <h2><?= htmlspecialchars($genreData['name']) ?></h2>
                </a>
            </div>
            <div class="container">
                <div class="books-grid">
                    <?php
                    /**
                     * Loop through each book in the current genre and render its cover and link.
                     * There are only up to 6 books per genre. (configurable in BookRepository)
                     *
                     * @var array $book Each element contains details of an individual book.
                     */
                    foreach ($genreData['books'] as $book):
                        ?>
                        <a class="nav-link" href="/book/<?= $book['id'] ?>">
                            <img src="<?= htmlspecialchars($book['cover']) ?>" alt="<?= htmlspecialchars($book['title']) ?>" class="book-placeholder">
                        </a>
                    <?php endforeach; ?>
                    <?php
                    /**
                     * Render a "See More" link to navigate to more books within the current genre.
                     */
                    ?>
                    <a href="/entity?type=genre&id=<?= $genreData['id'] ?>" class="nav-link">
                        <h2>See More <?= htmlspecialchars($genreData['name']) ?> Books</h2>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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