<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Panier - Absolute Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<?php include_once '../../includes/header.php'; ?>
<main class="container my-5">
    <div class="bg-light rounded p-4 shadow-sm mb-4">
        <h1 class="fs-2 mb-4 text-danger">Mon Panier</h1>
        <div id="cart-content">
            <div class="text-center">
                <div class="spinner-border text-danger" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p>Chargement de votre panier...</p>
            </div>
        </div>

        <div id="total-container" class="bg-light-subtle p-3 rounded mt-4 d-none">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4>Total</h4>
                </div>
                <div class="col-md-6 text-end">
                    <span id="total-price" class="fs-4 fw-bold text-danger">0,00 €</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="../../index.php" class="btn btn-outline-secondary me-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Revenir à la page d'accueil
            </a>
            <button id="checkout-btn" class="btn btn-danger d-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                </svg>
                Procéder au paiement
            </button>
        </div>
    </div>
</main>

<?php include_once '../../includes/footer.php'; ?>

<script src="view_cart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>