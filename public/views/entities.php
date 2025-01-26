<?php /** @var string $type */ ?>
<?php /** @var array $entities */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst(htmlspecialchars($type)) ?>s - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="/public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<main>
    <div class="container">
        <h1><?= ucfirst(htmlspecialchars($type)) ?>s</h1>
    </div>
    <div class="container column">
        <?php foreach ($entities as $entity): ?>
            <a href="/entity?type=<?= $type ?>&id=<?= $entity->getId() ?>" class="nav-link">
                <h4># <?= htmlspecialchars($entity->getName()); ?></h4>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>