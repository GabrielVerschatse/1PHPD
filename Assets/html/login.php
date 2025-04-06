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

<form style="margin: 50px auto; gap: 10px; max-width: 40vw" class="d-flex flex-column" action="" method="post">
    <h1 class="text-center">Connexion</h1>

    <div class="form-group">
        <label for="exampleInputEmail1">Adresse Email</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre email :)</small>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Mot de Passe</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="ZiggsEstLeMeilleur123">
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3">
        <button type="submit" class="btn btn-primary" style="width: 20vw;">Connexion</button>
    </div>
</form>

<?php include_once '../../includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>