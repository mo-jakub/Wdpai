<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Power Of Knowledge</title>
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

<main class="signup-page">
    <div class="auth-page">
        <div class="auth-info">
            <img src="public/images/on-page-logo.svg" alt="Logo" class="on-page-logo">
            <h2>Join us now.</h2>
            <p>So that you can share your thoughts regarding all the books and discuss them with others. It's free and easy.</p>
        </div>
        <div class="auth-form">
            <h2>Create an Account</h2>
            <form action="register.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Repeat Password" required>
                <button type="submit">Sign Up</button>
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
