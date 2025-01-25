<header>
    <div class="container">
        <a href="/" class="logo-link">
            <img src="/public/images/logo.svg" alt="Logo" class="logo">
            Power of Knowledge
        </a>
        <nav class="nav-wrapper">
            <a href="/" class="nav-link">
                <img src="/public/images/header/home.svg" alt="" class="logo">
                Home
            </a>
            <a href="/genres" class="nav-link">
                <img src="/public/images/header/box.svg" alt="" class="logo">
                Genres
            </a>
            <a href="/tags" class="nav-link">
                <img src="/public/images/header/tag.svg" alt="" class="logo">
                Tags
            </a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Search by title or author">
        </div>
        <nav class="nav-wrapper auth">
            <?php if (isset($_COOKIE['session_token'])): ?>
                <a href="/logout" class="nav-link">
                    <img src="/public/images/header/logout.svg" alt="" class="logo">
                    Logout
                </a>
            <?php else: ?>
                <a href="/login" class="nav-link">
                    <img src="/public/images/header/login.svg" alt="" class="logo">
                    Login
                </a>
                <a href="/register" class="nav-link">
                    <img src="/public/images/header/signup.svg" alt="" class="logo">
                    Sign Up
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>