<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Of Knowledge</title>
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

<main>
<!-- <?php foreach($books as $book): ?>
 
 <div class="card">
     <img src="https://random.imagecdn.app/700/700">
     <p>
        <?= $book["name"]; ?>
     </p>
 </div>
<?php endforeach; ?> -->
    <div class="books-grid">
        <img src="https://random.imagecdn.app/700/700" alt="Book 1" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 2" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 3" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 4" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 5" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 6" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 7" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 8" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 9" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 10" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 11" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 12" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 1" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 2" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 3" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 4" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 5" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 6" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 7" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 8" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 9" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 10" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 11" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 12" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 1" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 2" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 3" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 4" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 5" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 6" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 7" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 8" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 9" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 10" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 11" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 12" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 1" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 2" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 3" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 4" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 5" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 6" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 7" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 8" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 9" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 10" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 11" class="book-placeholder">
        <img src="https://random.imagecdn.app/700/700" alt="Book 12" class="book-placeholder">
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