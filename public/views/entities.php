<?php /** @var string $type */ ?>
<?php /** @var array $entities */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(htmlspecialchars($type)) ?>s - Power Of Knowledge</title>

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
        <!-- Display the title for the entities page -->
        <h1><?= ucfirst(htmlspecialchars($type)) ?>s</h1>

        <!-- Iterate through and display each entity -->
        <?php foreach ($entities as $entity): ?>
            <a href="/entity?type=<?= $type ?>&id=<?= $entity->getId() ?>" class="nav-link">
                <!-- Display the name of the entity -->
                <h4># <?= htmlspecialchars($entity->getName()); ?></h4>
            </a>
        <?php endforeach; ?>
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