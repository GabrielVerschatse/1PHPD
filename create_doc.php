<?php

// Créez un fichier generate-swagger.php

require '../../vendor/autoload.php'; // Assurez-vous que swagger-php est installé

$openapi = \OpenApi\Generator::scan(['./client.php']);
file_put_contents('swagger.json', $openapi->toJson());

echo "Documentation JSON générée avec succès!";
?>