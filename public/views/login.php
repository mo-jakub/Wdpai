<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Power Of Knowledge</title>
    <link rel="stylesheet" type="text/css" href="public/styles/style.css">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="/" class="nav-link">
                <img src="placeholder1.jpg" alt="Logo">
                Power of Knowledge
            </a>
        </div>
        <nav class="nav-wrapper">
            <a href="/" class="nav-link">Home</a>
            <a href="/" class="nav-link">Genre</a>
            <a href="/" class="nav-link">Tags</a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Search by title or author">
        </div>
        <nav class="nav-wrapper auth">
            <a href="/login" class="nav-link">Login</a>
            <a href="/register" class="nav-link">Sign Up</a>
        </nav>
    </div>
</header>

<main class="login-page">
    <div class="auth-page">
        <div class="login-info">
            <img src="logo.png" alt="Logo" class="onpage-logo">
            <h2>We're glad to have you back.</h2>
        </div>
        <div class="login-form">
            <form action="login.php" method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-nav">
            <button>About Us</button>
            <button>Contact</button>
        </div>
        <div class="nav-wrapper">
            <a href="#" class="nav-link">Twitter</a>
            <a href="#" class="nav-link">Facebook</a>
            <a href="#" class="nav-link">Discord</a>
        </div>
    </div>
</footer>
</body>
</html>