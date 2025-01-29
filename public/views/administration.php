<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')
{
    header('Location: /');
    exit();
}
?>
<?php /** @var string $action */ ?>
<?php /** @var array $types */ ?>
<?php /** @var array $books */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>

<body>

<?php include 'public/views/parts/header.php'; ?>

<main>
    <aside class="menu column">
        <h3>Administration</h3>
        <a href="/administration" class="nav-link">Edit Books</a>
        <a href="/administration?action=author" class="nav-link">Edit Authors</a>
        <a href="/administration?action=tag" class="nav-link">Edit Tags</a>
        <a href="/administration?action=genre" class="nav-link">Edit Genres</a>
    </aside>
<?php switch ($action): ?>
<?php case '': ?>
    <table class="page-with-menu column border">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Authors</th>
            <th>Tags</th>
            <th>Genres</th>
            <th></th>
        </tr>
        <?php foreach ($books as $book) : ?>
            <tr>
                <td><?= htmlspecialchars($book['id']) ?></td>
                <th><?= htmlspecialchars($book['title']) ?></th>
                <td><?= htmlspecialchars($book['description']) ?></td>
                <th>
                    <?php
                    $authors = str_getcsv(trim($book['authors'], '{}'));
                    foreach ($authors as $author) : ?>
                        <?= htmlspecialchars($author) ?>
                    <?php endforeach; ?>
                </th>
                <th>
                    <?php
                    $tags = str_getcsv(trim($book['tags'], '{}'));
                    foreach ($tags as $tag) : ?>
                        <?= htmlspecialchars($tag) ?>
                    <?php endforeach; ?>
                </th>
                <th><?php
                    $genres = str_getcsv(trim($book['genres'], '{}'));
                    foreach ($genres as $genre) : ?>
                    <?= htmlspecialchars($genre) ?>
                    <?php endforeach; ?>
                </th>
                <td>
                    <form action="/deleteBook">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                        <button>
                            <img src="/public/images/admin/trash.svg" alt="Delete" class="logo">
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <form action="/addBook" method="post">
                <th><input type="text" name="title" placeholder="Enter book title" required></th>
                <th><input type="text" name="description" placeholder="Enter book description" required></th>
                <?php foreach ($types as $type) : ?>
                    <th><select class="container" name="<?= $type['type'] ?>[]" multiple size="2">
                            <?php foreach ($type['entities'] as $entity) : ?>
                            <option value="<?= $entity->getId() ?>">
                                <?= htmlspecialchars($entity->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    </th>
                <?php endforeach; ?>
                <th>
                    <button type="submit">
                        <img src="/public/images/admin/plus.svg" alt="Add" class="logo">
                    </button>
                </th>
            </form>
        </tr>
    </table>
<?php break; ?>
<?php case in_array($action, ['tag', 'genre', 'author']):
    foreach ($types as $type) {
        if ($type['type'] === $action) {
            $entities = $type['entities'];
            break;
        }
    }
?>
    <table class="page-with-menu column border">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th></th>
        </tr>
        <?php foreach ($type['entities'] as $entity) : ?>
            <tr>
                <th><?= htmlspecialchars($entity->getId()) ?></th>
                <th><?= htmlspecialchars($entity->getName()) ?></th>
                <th><form action="/deleteEntity" method="post">
                        <input type="hidden" name="type" value="<?= $action ?>">
                        <input type="hidden" name="id" value="<?= $entity->getId() ?>">
                        <button type="submit">
                            <img src="/public/images/admin/trash.svg" alt="Delete" class="logo">
                    </button></form></th>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <form action="/addEntity" method="post">
                <th>
                    <input type="hidden" name="type"  value="<?= $type['type'] ?>">
                    <input type="text" name="name" placeholder="Enter <?= $type['type'] ?> name" required>
                </th>
                <th>
                    <button type="submit">
                        <img src="/public/images/admin/plus.svg" alt="Add" class="logo">
                    </button>
                </th>
            </form>
        </tr>
    </table>
<?php break; ?>
<?php endswitch; ?>
</main>

<?php include 'public/views/parts/footer.php'; ?>

</body>
</html>