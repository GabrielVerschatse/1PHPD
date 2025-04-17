<?php global $pdo; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Films du réalisateur - Absolute Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .movie-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<?php include_once '../../includes/header.php'; ?>

<main class="container my-5">
    <div class="back-button mb-4">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Retour
        </a>
    </div>

    <div id="directorMovies">
        <?php
        if (isset($_GET['director']) && !empty($_GET['director'])) {
            $director = $_GET['director'];
            echo "<h1 class='mb-4'>Films réalisés par <span class='text-danger'>" . htmlspecialchars($director) . "</span></h1>";

            echo '<div id="moviesContainer" class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col-12 text-center">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>';
        } else {
            echo '<div class="alert alert-danger">Aucun réalisateur spécifié</div>';
        }
        ?>
    </div>
</main>

<?php include_once '../../includes/footer.php'; ?>
<script src="director_movies.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>