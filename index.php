<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absolute Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<?php include_once 'includes/header.php'; ?>


<h1 class="display-1 my-2 text-center">Absolute Cinema</h1>
<h2 class="display-2 my-2 text-center">The best place to find the next masterpiece</h2>

<div class="row row-cols-1 row-cols-md-4 g-4 my-5 mx-5">
  <div class="col">
    <div class="card">
      <img src="https://preview.redd.it/a4pu8ndutofe1.jpeg?auto=webp&s=9fe553e20cdfa5ce4ea4b023589692cb4ffd756e" class="card-img-top img-fluid pt-2" style="max-height: 350px; object-fit: contain;" alt="...">
      <div class="card-body">
        <h5 class="card-title">Minecraft, the Movie</h5>
        <small class="text-body-secondary">2025 |</small>
        <small class="text-body-secondary">Price : 10.99</small>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-danger">Plus d'informations</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card">
      <img src="" class="card-img-top" alt="">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
</div>


<?php include_once 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>