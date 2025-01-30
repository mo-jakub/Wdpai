<?php /** @var Book $book */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book->getTitle()) ?> - Power Of Knowledge</title>

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
    <div class="border" style="display: flex;">
        <!-- Display the book's cover along with its title -->
        <img src="<?= htmlspecialchars($book->getCover()) ?>" class="book-placeholder" alt="<?= htmlspecialchars($book->getTitle()) ?>">
        <div class="column">
            <!-- Display the book title -->
            <h2>Title: <?= htmlspecialchars($book->getTitle()) ?></h2>
            <!-- Section to display book authors -->
            <p>
                <strong>
                    <a href="/entities?type=author" class="nav-link">Author(s)</a>
                </strong>
                <!-- Loop through each author of the book -->
                <?php foreach ($book->getAuthors() as $author): ?>
                    <a href="/entity?type=author&id=<?= htmlspecialchars($author['id_author']) ?>" class="nav-link"><?= htmlspecialchars($author['author']) ?></a>
                <?php endforeach; ?>
            </p>
            <!-- Section to display book genres -->
            <p>
                <strong>
                    <a href="/entities?type=genre" class="nav-link">Genres</a>
                </strong>
                <!-- Loop through each genre of the book -->
                <?php foreach ($book->getGenres() as $genre): ?>
                    <a href="/entity?type=genre&id=<?= htmlspecialchars($genre['id_genre']) ?>" class="nav-link"><?= htmlspecialchars($genre['genre']) ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <div class="column border">
        <!-- Section to display book tags -->
        <strong>
            <a href="/entities?type=tag" class="nav-link">Tags</a>
        </strong>
        <!-- Loop through each tag of the book -->
        <?php foreach ($book->getTags() as $tag): ?>
            <a href="/entity?type=tag&id=<?= htmlspecialchars($tag['id_tag']) ?>" class="nav-link"><?= htmlspecialchars($tag['tag']) ?></a>
        <?php endforeach; ?>
    </div>
    <div class="column border">
        <!-- Display the book's description -->
        <strong>Description:</strong>
        <p><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
    </div>
    <div class="column border">
        <!-- Comments section -->
        <h3>Comments:</h3>
        <div class="container column border">
            <!-- Form to add a new comment -->
            <h3>Add a comment:</h3>
            <form class="container column" method="post" action="/addComment">
                <textarea class="border" name="comment" placeholder="Write your comment here..." required></textarea>
                <input type="hidden" name="bookId" value="<?= $book->getId() ?>">
                <button type="submit">Add Comment</button>
            </form>
        </div>
        <!-- Check if the book has any comments -->
        <?php if (count($book->getComments()) > 0): ?>
            <!-- Loop through each comment of the book -->
            <?php foreach ($book->getComments() as $comment): ?>
                <div class="container column border">
                    <!-- Display comment date -->
                    <small><?= htmlspecialchars($comment['date']) ?></small>
                    <!-- Link to the user who posted the comment -->
                    <strong>
                        <a href="/user/<?= htmlspecialchars($comment['id_user']) ?>" class="nav-link">
                            <img src="/public/images/user.svg" alt="" class="logo">
                            <?= htmlspecialchars($comment['username']) ?>:
                        </a>
                    </strong>
                    <!-- Display the comment content -->
                    <?= htmlspecialchars($comment['comment']) ?>
                    <!-- Check if the current user can delete the comment -->
                    <?php if (isset($_SESSION['userId'])): ?>
                        <?php if (
                                $_SESSION['userId'] === $comment['id_user'] ||
                                $_SESSION['role'] === 'admin' ||
                                $_SESSION['role'] === 'moderator'
                        ): ?>
                            <!-- Form to delete the comment -->
                            <form method="post" action="/deleteComment">
                                <input type="hidden" name="commentId" value="<?= $comment['id_comment'] ?>">
                                <input type="hidden" name="userId" value="<?= $comment['id_user'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Display a message if there are no comments -->
            <p>No comments yet. Be the first to comment!</p>
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
