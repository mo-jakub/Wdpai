<header>
    <div class="container">
        <a href="/" class="nav-link">
            <img src="/public/images/logo.svg" alt="Logo" class="logo">
            Power of Knowledge
        </a>
        <nav class="nav-wrapper">
            <a href="/" class="nav-link">Home</a>
            <a href="/genres" class="nav-link">Genres</a>
            <a href="/" class="nav-link">Tags</a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Search by title or author">
        </div>
        <nav class="nav-wrapper auth">
            <?php if (isset($_COOKIE['session_token'])): ?>
                <a href="/logout" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="/login" class="nav-link">Login</a>
                <a href="/register" class="nav-link">Sign Up</a>
            <?php endif; ?>
        </nav>
    </div>
</header>