<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recherche de Films - Absolute Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        .search-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .filter-section {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }
        .movie-card {
            transition: transform 0.3s;
        }
        .movie-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
<?php include_once '../../includes/header.php'; ?>

<main class="container my-5">
    <h1 class="text-center mb-4">Rechercher un film</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="search-container">
                <h4 class="mb-3">Filtres de recherche</h4>
                <form id="searchForm">
                    <div class="filter-section">
                        <h5>Recherche</h5>
                        <div class="mb-3">
                            <label for="search" class="form-label">Titre, acteur ou réalisateur</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search"
                                       placeholder="Que recherchez-vous ?">
                                <button type="submit" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="filter-section">
                        <h5>Genre</h5>
                        <div class="mb-3">
                            <label for="genre"></label><select class="form-select" id="genre" name="genre">
                                <option value="">Tous les genres</option>
                                <option value="action">Action</option>
                                <option value="adventure">Aventure</option>
                                <option value="animation">Animation</option>
                                <option value="comedy">Comédie</option>
                                <option value="crime">Policier</option>
                                <option value="documentary">Documentaire</option>
                                <option value="drama">Drame</option>
                                <option value="family">Famille</option>
                                <option value="fantasy">Fantastique</option>
                                <option value="history">Historique</option>
                                <option value="horror">Horreur</option>
                                <option value="music">Musical</option>
                                <option value="mystery">Mystère</option>
                                <option value="romance">Romance</option>
                                <option value="science_fiction">Science-Fiction</option>
                                <option value="thriller">Thriller</option>
                                <option value="war">Guerre</option>
                                <option value="western">Western</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-section">
                        <h5>Tri par date</h5>
                        <div class="mb-3">
                            <label for="sort"></label><select class="form-select" id="sort" name="sort">
                                <option value="recent">Plus récent au plus ancien</option>
                                <option value="old">Plus ancien au plus récent</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="reset" class="btn btn-outline-secondary">Réinitialiser les filtres</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="mb-4">
                <h4>Résultats de recherche</h4>
                <hr>
            </div>
            <div id="searchResults">
                <div class="text-center text-muted">
                    <p>Utilisez les filtres pour rechercher des films</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once '../../includes/footer.php'; ?>
<script src="search.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>