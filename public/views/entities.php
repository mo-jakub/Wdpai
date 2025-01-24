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
<div class="entity-selection container">
    <h1><?= ucfirst(htmlspecialchars($type)) ?>s</h1>
    <div class="entity-grid">
        <?php foreach ($entities as $entity): ?>
            <a href="/<?= $type ?>/<?= $entity->getId() ?>">
                <div class="entity-card">
                    <img src="https://random.imagecdn.app/700/700" alt="<?= htmlspecialchars($entity->getName()); ?>" class="entity-placeholder">
                    <h3><?= htmlspecialchars($entity->getName()); ?></h3>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>