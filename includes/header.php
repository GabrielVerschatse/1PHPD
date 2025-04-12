<header>
    <style>
        .hide{
            display: none !important;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-dark bg-black py-3">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/1PHPD/index.php">
            <span class="fw-bold fs-4">Absolute Cinema</span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/1PHPD/Assets/category/category.php?category=drama">Drama</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/1PHPD/Assets/category/category.php?category=action">Action</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">Rechercher un film</a>
                </li>
            </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Sign In button -->
                    <button class="btn btn-outline-danger align-items-center gap-2 not-login" id="connexion">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    Connexion
                    </button>

                    <!-- Cart button -->
                    <button class="btn btn-outline-danger align-items-center gap-2 login hide" id="cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="10" cy="20.5" r="1"/><circle cx="18" cy="20.5" r="1"/><path d="M2.5 2.5h3l2.7 12.4a2 2 0 0 0 2 1.6h7.7a2 2 0 0 0 2-1.6l1.6-8.4H7.1"/>
                        </svg>
                    </button>

                    <!-- Profil button -->
                    <button class="btn btn-outline-danger align-items-center gap-2 login hide" id="profil">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <script src="/1PHPD/includes/header.js"></script>
</header>