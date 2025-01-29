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

<?php include 'public/views/parts/header.php'; ?>

<main class="page">
    <div class="info">
        <img src="/public/images/on-page-logo.svg" alt="Logo" class="on-page-logo">
        <h3>
            <?php if ($_GET['page'] === 'about'): ?>
                <p>Power of Knowledge:</p>
                <p>It's a simple project made for a class about developing web applications.</p>
                <p>It won't have any groundbreaking features or functionalities.</p>
                <p>I only hope to at least make it look semi-decent and be more or less functional.</p>
            <?php elseif ($_GET['page'] === 'contact'): ?>
                <p>Do not contact.</p>
            <?php else: header('Location: /Error404'); exit();?>
            <?php endif; ?>
        </h3>
    </div>
</main>

<?php include 'public/views/parts/footer.php'; ?>

</body>
</html>