<?php global $pdo; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails du film - Absolute Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .movie-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .movie-title {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #dc3545;
        }
        .movie-details {
            margin-bottom: 20px;
        }
        .movie-details .badge {
            font-size: 1rem;
            padding: 8px 15px;
            margin-right: 10px;
        }
        .movie-description {
            line-height: 1.7;
            margin-top: 20px;
        }
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php include_once '../../includes/header.php'; ?>

<main class="container my-5">
    <?php
    $movie_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if (!$movie_id) {
        echo '<div class="alert alert-danger">Aucun film spécifié</div>';
    } else {
        require_once '../../API/connection_bdd.php';

        try {
            $stmt = $pdo->prepare("SELECT movies.*, 
    GROUP_CONCAT(DISTINCT CONCAT(actor.firstname, ' ', actor.lastname) SEPARATOR ', ') AS actor_names,
    GROUP_CONCAT(DISTINCT CONCAT(director.firstname, ' ', director.lastname) SEPARATOR ', ') AS director_names
    FROM movies 
    LEFT JOIN movies_actor ON movies.id = movies_actor.movie_id 
    LEFT JOIN actor ON movies_actor.actor_id = actor.id 
    LEFT JOIN movies_director ON movies.id = movies_director.movie_id
    LEFT JOIN director ON movies_director.director_id = director.id
    WHERE movies.id = ?
    GROUP BY movies.id");
            $stmt->execute([$movie_id]);
            $movie = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$movie) {
                echo '<div class="alert alert-danger">Film non trouvé</div>';
            } else {
    ?>
                <div class="back-button">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Retour
                    </a>
                </div>

                <div class="movie-card">
                    <h1 class="movie-title"><?= htmlspecialchars($movie['title']) ?></h1>

                    <div class="movie-details">
                        <span class="badge bg-danger">Prix: <?= number_format($movie['price'], 2) ?> €</span>
                        <span class="badge bg-secondary">Genre: <?= htmlspecialchars($movie['genre']) ?></span>
                        <span class="badge bg-info text-dark">Date de sortie: <?= htmlspecialchars($movie['release_date']) ?></span>
                        <span class="badge bg-info text-dark">Réalisateur:
                        <?php
                        if (!empty($movie['director_names'])) {
                            $directors = explode(', ', $movie['director_names']);
                            $directorLinks = [];
                            foreach ($directors as $director) {
                                $nameParts = explode(' ', $director);
                                $lastName = end($nameParts);
                                $directorLinks[] = '<a href="director_movies.php?director=' . urlencode($lastName) . '" class="text-white">' . htmlspecialchars($director) . '</a>';
                            }
                            echo implode(', ', $directorLinks);
                        } else {
                            echo 'Non disponible';
                        }
                        ?>
                        </span>
                        <span class="badge bg-info text-dark">Acteurs:
                            <?= !empty($movie['actor_names']) ? htmlspecialchars($movie['actor_names']) : 'Non disponible'; ?>
                        </span>
                    </div>

                    <?php if (!empty($movie['video'])): ?>
                    <div class="video-container">
                        <iframe src="<?= htmlspecialchars($movie['video']) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <?php endif; ?>

                    <div class="movie-description">
                        <h4>Synopsis</h4>
                        <p><?= nl2br(htmlspecialchars($movie['big_description'])) ?></p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="" id="addToCart" class="btn btn-danger btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 0h6a2 2 0 1 0 0 0h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Ajouter au panier
                        </a>
                    </div>
                </div>
    <?php
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Erreur de base de données: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
    ?>
</main>

<?php include_once '../../includes/footer.php'; ?>
<script src="more_info.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>