<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absolute Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <?php include_once '../../includes/header.php'; ?>

    <form style="margin: 50px auto; gap: 10px; max-width: 400px; padding: 20px;" class="d-flex flex-column" method="post">

        <div class="d-flex justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>

        <h1 class="text-center">Création de votre compte</h1>

        <div class="input-group mt-4 mb-2">
            <label for="firstname" class="input-group-text">Nom</label>
            <input type="text" class="form-control" aria-label="Username" placeholder="Ziggs" name="firstname" required>
        </div>

        <div class="input-group mb-2">
            <label for="lastname" class="input-group-text">Prénom</label>
            <input type="text" class="form-control" aria-label="Username" placeholder="Herbert" name="lastname" required>
        </div>

        <div class="form-group">
            <label for="phone">Numéro de téléphone</label>
            <input type="tel" class="form-control" placeholder="0606060606" name="phone">
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre email :)</small>
        </div>

        <div class="form-group mb-4">
            <label for="password">Mot de Passe</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
            <button type="submit" class="btn btn-danger">S'inscrire</button>
        </div>
    </form>

    <?php include_once '../../includes/footer.php'; ?>
    <script src="register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>