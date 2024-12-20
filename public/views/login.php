<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="public/styles/style.css">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<main class="auth-page">
    <div class="auth-info">
        <img src="public/images/on-page-logo.svg" alt="Logo" class="on-page-logo">
        <h2>We're glad to have you back.</h2>
    </div>
    <div class="auth-form">
        <h2>Log Into an Existing Account</h2>
        <form action="login.php" method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>