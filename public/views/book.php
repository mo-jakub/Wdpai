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
            <img src="https://random.imagecdn.app/700/700" class="book-placeholder" alt="<?= htmlspecialchars($book->getTitle()) ?>">
        </div>
        <div class="details">
            <h2>Title: <?= htmlspecialchars($book->getTitle()) ?></h2>
            <p>
                <strong>
                    <a href="/authors" class="nav-link">Author(s)</a>
                </strong> 
                <?php foreach ($book->getAuthors() as $author): ?>
                    <a href="/author/<?= htmlspecialchars($author['id_author']) ?>" class="nav-link"><?= htmlspecialchars($author['author']) ?></a>
                <?php endforeach; ?>
            </p>
            <p>
                <strong>
                    <a href="/genres" class="nav-link">Genres</a>
                </strong> 
                <?php foreach ($book->getGenres() as $genre): ?>
                    <a href="/genre/<?= htmlspecialchars($genre['id_genre']) ?>" class="nav-link"><?= htmlspecialchars($genre['genre']) ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <div class="tags">
        <p>
            <strong>
                <a href="/tags" class="nav-link">Tags</a>
            </strong>
        </p>
        <ul>
            <?php foreach ($book->getTags() as $tag): ?>
                <li><a href="/tag/<?= htmlspecialchars($tag['id_tag']) ?>" class="nav-link"><?= htmlspecialchars($tag['tag']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="desc">
        <p><strong>Description:</strong></p>
        <p><?= nl2br(htmlspecialchars($book->getDescription())) ?></p>
    </div>
    <div class="comments">
        <h3>Comments:</h3>
        <?php if (count($book->getComments()) > 0): ?>
            <ul>
                <?php foreach ($book->getComments() as $comment): ?>
                    <li>
                        <p><strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= htmlspecialchars($comment['comment']) ?></p>
                        <p><small><?= htmlspecialchars($comment['date']) ?></small></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments yet. Be the first to comment!</p>
        <?php endif; ?>
    </div>
    <div class="add-comment">
        <h3>Add a comment:</h3>
        <form method="post" action="/book/<?= $book->getId() ?>/comment">
            <textarea name="comment" placeholder="Write your comment here..." required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>
