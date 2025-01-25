<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="public/styles/style.css">
    <link rel="icon" type="image/png" href="/public/images/logo.svg">
    <script src="/public/scripts/registerValidation.js"></script>
</head>
<body>

<?php
if (isset($_COOKIE['session_token'])) {
    header('Location: /');
    exit();
}
?>

<?php include 'public/partials/header.php'; ?>

<main class="auth-page">
        <div class="auth-info">
            <img src="public/images/on-page-logo.svg" alt="Logo" class="on-page-logo">
            <h2>Join us now.</h2>
            <p>So that you can share your thoughts</p>
            <p>regarding all the books</p>
            <p>and discuss them with others.</p>
            <p>It's free and easy.</p>
        </div>
        <div class="auth-form">
            <h2>Create an Account</h2>
            <form action="/register" method="post">
                <input type="text" name="username" placeholder="Username" value="<?= $default['username'] ?? ''; ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?= $default['email'] ?? ''; ?>" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Repeat Password" required>
                <label><?= $message ?? ''; ?></label>
                <button type="submit">Sign Up</button>
            </form>
        </div>
</main>

<?php include 'public/partials/footer.php'; ?>

</body>
</html>
