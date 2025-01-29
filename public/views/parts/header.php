<script src="/public/scripts/menu.js"></script>
<script src="/public/scripts/sessionRenew.js"></script>
<script src="/public/scripts/searchBooks.js"></script>
<link rel="stylesheet" type="text/css" href="/public/styles/search.css">
<header>
    <div class="container">
        <div class="mobile-header container">
            <a href="/" class="logo-link">
                <img src="/public/images/logo.svg" alt="Logo" class="logo">
                Power of Knowledge
            </a>
            <div class="mobile-nav">
                <div class="menu-icon">
                    <img src="/public/images/header/menu.svg" alt="Menu">
                </div>
                <div class="dropdown-menu">
                    <form class="search-bar mobile-search-bar">
                        <input type="text" placeholder="Search by title or author">
                    </form>
                    <a href="/" class="nav-link">
                        <img src="/public/images/header/home.svg" alt="" class="logo">
                        Home
                    </a>
                    <a href="/entities?type=genre" class="nav-link">
                        <img src="/public/images/header/box.svg" alt="" class="logo">
                        Genres
                    </a>
                    <a href="/entities?type=tag" class="nav-link">
                        <img src="/public/images/header/tag.svg" alt="" class="logo">
                        Tags
                    </a>
                    <?php if (isset($_COOKIE['session_token'])): ?>
                        <a href="/logout" class="nav-link">
                            <img src="/public/images/header/logout.svg" alt="" class="logo">
                            Logout
                        </a>
                        <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>" class="nav-link">
                            <img src="/public/images/user.svg" alt="" class="logo">
                            <?= htmlspecialchars($_SESSION['username']) ?>
                        </a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="/administration" class="nav-link">
                                <img src="/public/images/header/admin.svg" alt="" class="logo">
                                Administration
                            </a>
                        <?php endif; ?>
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
                </div>
            </div>
        </div>
        <div class="pc-header container">
            <a href="/" class="logo-link">
                <img src="/public/images/logo.svg" alt="Logo" class="logo">
                Power of Knowledge
            </a>
            <nav class="nav-wrapper">
                <a href="/" class="nav-link">
                    <img src="/public/images/header/home.svg" alt="" class="logo">
                    Home
                </a>
                <a href="/entities?type=genre" class="nav-link">
                    <img src="/public/images/header/box.svg" alt="" class="logo">
                    Genres
                </a>
                <a href="/entities?type=tag" class="nav-link">
                    <img src="/public/images/header/tag.svg" alt="" class="logo">
                    Tags
                </a>
            </nav>
            <form class="search-bar desktop-search-bar">
                <input type="text" placeholder="Search by title or author">
            </form>
            <nav class="nav-wrapper auth">
                <?php if (isset($_COOKIE['session_token'])): ?>
                    <a href="/logout" class="nav-link">
                        <img src="/public/images/header/logout.svg" alt="" class="logo">
                        Logout
                    </a>
                    <a href="/user/<?= htmlspecialchars($_SESSION['userId']) ?>" class="nav-link">
                        <img src="/public/images/user.svg" alt="" class="logo">
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="/administration" class="nav-link">
                            <img src="/public/images/header/admin.svg" alt="" class="logo">
                            Administration
                        </a>
                    <?php endif; ?>
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
    </div>
</header>