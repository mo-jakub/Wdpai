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

<main class="container">
    <div class="container">
        <img src="https://random.imagecdn.app/700/700" class="book-placeholder" alt="<?= htmlspecialchars($book->getTitle()) ?>">
        <div class="container column border">
            <h2>Title: <?= htmlspecialchars($book->getTitle()) ?></h2>
            <p>
                <strong>
                    <a href="/entities?type=author" class="nav-link">Author(s)</a>
                </strong>
                <?php foreach ($book->getAuthors() as $author): ?>
                    <a href="/entity?type=author&id=<?= htmlspecialchars($author['id_author']) ?>" class="nav-link"><?= htmlspecialchars($author['author']) ?></a>
                <?php endforeach; ?>
            </p>
            <p>
                <strong>
                    <a href="/entities?type=genre" class="nav-link">Genres</a>
                </strong>
                <?php foreach ($book->getGenres() as $genre): ?>
                    <a href="/entity?type=genre&id=<?= htmlspecialchars($genre['id_genre']) ?>" class="nav-link"><?= htmlspecialchars($genre['genre']) ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <div class="container">
        <div class="column border">
            <strong>
                <a href="/entities?type=tag" class="nav-link">Tags</a>
            </strong>
            <?php foreach ($book->getTags() as $tag): ?>
                <a href="/entity?type=tag&id=<?= htmlspecialchars($tag['id_tag']) ?>" class="nav-link"><?= htmlspecialchars($tag['tag']) ?></a>
            <?php endforeach; ?>
        </div>
        <div class="container column border">
            <strong>Description:</strong>
            <?= nl2br(htmlspecialchars($book->getDescription())) ?>
        </div>
    </div>
    <div class="container column">
        <h3>Comments:</h3>
        <div class="container column border">
            <h3>Add a comment:</h3>
            <form method="post" action="/addComment">
                <textarea name="comment" placeholder="Write your comment here..." required></textarea>
                <input type="hidden" name="bookId" value="<?= $book->getId() ?>">
                <button type="submit">Submit</button>
            </form>
        </div>
        <?php if (count($book->getComments()) > 0): ?>
            <?php foreach ($book->getComments() as $comment): ?>
                <div class="container column border">
                    <small><?= htmlspecialchars($comment['date']) ?></small>
                    <strong>
                        <a href="/user/<?= htmlspecialchars($comment['id_user']) ?>" class="nav-link">
                            <img src="/public/images/user.svg" alt="" class="logo">
                            <?= htmlspecialchars($comment['username']) ?>:
                        </a>
                    </strong>
                    <?= htmlspecialchars($comment['comment']) ?>
                    <?php if (isset($_SESSION['userId'])): ?>
                        <?php if (
                                $_SESSION['userId'] === $comment['id_user'] ||
                                $_SESSION['role'] === 'admin' ||
                                $_SESSION['role'] === 'moderator'
                        ): ?>
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
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>
