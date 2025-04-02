<?php


// Handle database connection
$dsn = 'mysql:host=bqckkitimaau4udfv2ho-mysql.services.clever-cloud.com;dbname=bqckkitimaau4udfv2ho;charset=utf8mb4';
$username = 'ulyytigymynzgquu';
$password = 'fWznVBIQwZ9m1uUHhHUI';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
$pdo = null;

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Verify token based connection

function authorized($user_id, $token) {
    global $pdo;

    // Check if the user exists and verify the token
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user && strcmp($user["token"], $token) == 0) {
        return true;
    } else {
        return false;
    }
}



?>