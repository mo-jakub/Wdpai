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

<?php include 'public/views/parts/header.php'; ?>

<main>
    <div class="container column">
        <h1><?= ucfirst(htmlspecialchars($type)) ?>s</h1>
        <?php foreach ($entities as $entity): ?>
            <a href="/entity?type=<?= $type ?>&id=<?= $entity->getId() ?>" class="nav-link">
                <h4># <?= htmlspecialchars($entity->getName()); ?></h4>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'public/views/parts/footer.php'; ?>

</body>
</html>