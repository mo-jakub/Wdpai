<?php
// Ensure the user has the 'admin' role. Redirect if unauthorized.
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

    <!-- Stylesheet -->
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">

    <!-- Website favicon -->
    <link rel="icon" type="image/png" href="/public/images/logo.svg">

    <!-- JavaScript for confirm deletion functionality -->
    <script src="/public/scripts/confirmDeletion.js"></script>
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
    <aside class="menu column">
        <!-- Sidebar menu for navigating between administration sections -->
        <h3>Administration</h3>
        <a href="/administration" class="nav-link">Edit Books</a>
        <a href="/administration?action=author" class="nav-link">Edit Authors</a>
        <a href="/administration?action=tag" class="nav-link">Edit Tags</a>
        <a href="/administration?action=genre" class="nav-link">Edit Genres</a>
    </aside>
    <?php
    /**
     * The main content switches based on the value of $action.
     * - If $action is empty, the Book Management section is shown.
     * - If $action is 'author', 'tag', or 'genre', the respective entity management section is loaded.
     */
    switch ($action): ?>
<?php
/**
 * Book Management Section
 * - Displays a list of all books with editable fields for title, description, authors, tags, genres, and cover.
 * - Provides functionality for deleting existing book or adding a new one.
 */
case '': ?>
    <table class="page-with-menu column border">
        <!-- Table headers for Book Management -->
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Authors</th>
            <th>Tags</th>
            <th>Genres</th>
            <th>Cover</th>
            <th></th>
        </tr>
        <?php
        // Loop through each book, displaying its editable fields in a form.
        foreach ($books as $book) : ?>
            <tr>
                <th><?= htmlspecialchars($book['id']) ?></th>
                <form action="/editBook" method="post" enctype="multipart/form-data">
                    <th>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                        <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                    </th>
                    <th>
                        <input type="text" name="description" value="<?= htmlspecialchars($book['description']) ?>" required>
                    </th>
                    <th>
                        <!-- Editable authors field -->
                        <select class="container" name="author[]" multiple>
                            <?php foreach ($types[0]['entities'] as $author): ?>
                                <option value="<?= $author->getId() ?>"
                                    <?= in_array($author->getName(), str_getcsv(trim($book['authors'], '{}'))) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($author->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </th>
                    <th>
                        <!-- Editable tags field -->
                        <select class="container" name="tag[]" multiple>
                            <?php foreach ($types[2]['entities'] as $tag): ?>
                                <option value="<?= $tag->getId() ?>"
                                    <?= in_array($tag->getName(), str_getcsv(trim($book['tags'], '{}'))) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tag->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </th>
                    <th>
                        <!-- Editable genres field -->
                        <select class="container" name="genre[]" multiple>
                            <?php foreach ($types[1]['entities'] as $genre): ?>
                                <option value="<?= $genre->getId() ?>"
                                    <?= in_array($genre->getName(), str_getcsv(trim($book['genres'], '{}'))) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($genre->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </th>
                    <th>
                        <?php if (!empty($book['cover'])): ?>
                            <!-- Display the current cover -->
                            <img src="<?= htmlspecialchars($book['cover']) ?>" alt="Current Cover" style="max-width: 100px; max-height: 100px;">
                            <input type="hidden" name="current_cover" value="<?= htmlspecialchars($book['cover']) ?>">
                        <?php endif; ?>
                        <!-- File input for uploading a new cover -->
                        <input type="file" name="cover" value="<?= $book['cover'] ?>" accept="image/*">
                    </th>

                    <td>
                        <!-- Save and delete buttons -->
                        <button type="submit">
                            <img src="/public/images/admin/save.svg" alt="Save" class="logo">
                        </button>
                </form>
                    <form action="/deleteBook" method="post">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">
                        <button type="button"
                                data-delete
                                data-id="<?= htmlspecialchars($book['id']) ?>"
                                data-url="/deleteBook">
                            <img src="/public/images/admin/trash.svg" alt="Delete" class="logo">
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <!-- Fields for adding a new book -->
            <form action="/addBook" method="post" enctype="multipart/form-data">
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
                    <input type="file" name="cover" accept="image/*">
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
<?php
/**
 * Entity Management Section
 * - Displays a list of entities (authors, genres, or tags) with editable fields for their names.
 * - Supports adding new entities to the list.
 */
case in_array($action, ['tag', 'genre', 'author']):
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
                <form action="/editEntity" method="post">
                    <th><?= htmlspecialchars($entity->getId()) ?></th>
                    <th>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($entity->getId()) ?>">
                        <input type="hidden" name="type" value="<?= $action ?>">
                        <input type="text" name="name"
                               value="<?= htmlspecialchars($entity->getName()) ?>"
                               required>
                    </th>
                    <th>
                        <!-- Save and delete buttons for entities -->
                        <button type="submit">
                            <img src="/public/images/admin/save.svg" alt="Save" class="logo">
                        </button>
                        <button type="button"
                                data-delete
                                data-id="<?= $entity->getId() ?>"
                                data-type="<?= $action ?>"
                                data-url="/deleteEntity">
                            <img src="/public/images/admin/trash.svg" alt="Delete" class="logo">
                        </button>

                    </th>
                </form>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <!-- Fields for adding a new entity -->
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

<?php
/**
 * Include the footer section of the site.
 * - This is a reusable view component for site-wide branding and information.
 */
include 'public/views/parts/footer.php';
?>

</body>
</html>