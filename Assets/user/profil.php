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

    <main class="container row justify-content-center my-5 mx-auto gap-5">

        <div class="col-12 col-md-6 d-flex justify-content-center flex-column align-items-center mx-auto gap-3" style="max-width: 400px">
            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <h1 class="text-center" id="data-insertion">Votre profil</h1>
            <button class='btn btn-danger' id="logout">
                Déconnexion
            </button>
        </div>


        <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center gap-3 mx-auto">
            <h1 class="text-center">Changer votre Mot de Passe</h1>
            <! -- Pas obligé de mettre une method (y'a pas de put) et d'attribut action car JS -->
            <form class="table-responsive" method="post">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><label for="old_password">Ancien Mot de Passe</label></td>
                            <td><input type="password" class="form-control" name="old_password" required></td>
                        </tr>
                        <tr>
                            <td><label for="new_password">Nouveau Mot de Passe</label></td>
                            <td><input type="password" class="form-control" name="new_password" required></td>
                        </tr>
                        <tr>
                            <td><label for="confirm_password">Confirmer le Mot de Passe</label></td>
                            <td><input type="password" class="form-control" name="confirm_password" required></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger" id="reset_password">Réinitialiser</button>
                </div>
            </form>
        </div>

        <section class="container my-5">
            <h2 class="mb-4 text-center">Vos Films</h2>
            <div class="d-flex flex-column gap-4" id="card_container">
                <!-- Les films seront insérés ici par JS -->
            </div>
        </section>
    </main>



    <?php include_once '../../includes/footer.php'; ?>
    <script src="profil.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>