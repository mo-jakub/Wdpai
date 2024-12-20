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
        <a href="/" class="nav-link">
            <img src="public/images/logo.svg" alt="Logo" class="logo">
            Power of Knowledge
        </a>
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
    </div>
</main>

<footer>
    <div class="container">
        <div class="footer-nav">
            <button>About Us</button>
            <button>Contact</button>
        </div>
        <div class="nav-wrapper">
            <a href="#" class="nav-link">
                <img src="public/images/twitter.svg" alt="Twitter" class="logo">
            </a>
            <a href="#" class="nav-link">
                <img src="public/images/facebook.svg" alt="Facebook" class="logo">
            </a>
            <a href="#" class="nav-link">
                <img src="public/images/discord.svg" alt="Discord" class="logo">
            </a>
        </div>
    </div>
</footer>
</body>
</html>