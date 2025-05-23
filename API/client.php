<?php
require 'connection_bdd.php';


// Handle Post requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input = json_decode(file_get_contents("php://input"), true);

    if ($input["action"] == "register") {
        register_user($input);

    } elseif ($input["action"] == "login") {
        login_user($input);

    } elseif ($input["action"] == "change_password") {
        change_password($input);
    } elseif ($input["action"] == "add_movie") {
        echo $input["action"];
        var_dump($input);
        add_movie_to_user($input);
    } else {
        http_response_code(400);
        echo json_encode("Invalid action");
    }
} else if($_SERVER["REQUEST_METHOD"] == "PUT") {
    $input = json_decode(file_get_contents("php://input"), true);
    change_password($input);

} else if($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        movies_own($_GET["id"]);
    }
} else{
    http_response_code(400);
    echo json_encode("Invalid Method");
}




function register_user($input)  {
    global $pdo;

    // Check if required fields are empty
    if (empty($input["firstname"])) {
        http_response_code(400);
        echo json_encode(["errorMessage" => "firstname field is required"]);
    } else if (empty($input["lastname"])) {
        http_response_code(400);
        echo json_encode(["errorMessage" => "lastname field is required"]);
    } else if (empty($input["email"]) || !filter_var($input["email"], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["errorMessage" => "email field is required"]);
    } else if (empty($input["password"])) {
        http_response_code(400);
        echo json_encode(["errorMessage" => "password field is required"]);

    } else {
        $firstname = htmlspecialchars($input["firstname"]);
        $lastname = htmlspecialchars($input["lastname"]);
        $email = htmlspecialchars($input["email"]);
        $phone = isset($input["phone"]) ? htmlspecialchars($input["phone"]) : NULL;
        $password = password_hash($input["password"], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO user (firstname, lastname, phone, email, password) VALUES (:firstname, :lastname, :phone, :email, :password)");
        $stmt->execute(["firstname" => $firstname, "lastname" => $lastname, "phone" => $phone, "email" => $email, "password" => $password]);

        echo json_encode(["status" => "Success", "message" => "User registered successfully"]);
    }
}





function login_user($input) {
    global $pdo;

    if (empty($input["email"])) {
        http_response_code(400);
        echo json_encode("Email field is required");

    } else if (empty($input["password"])) {
        http_response_code(400);
        echo json_encode("password field is required");

    } else {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$input["email"]]);
        $user = $stmt->fetch();             // Return a array (dictionary) that contains the user data (cuz default fetch mode is PDO::FETCH_ASSOC)

        if ($user && password_verify($input["password"], $user["password"])) {
            // Remove the password before sending response
            unset($user["password"]);

            // Create a token for the user session and store it in the database
            $token = bin2hex(random_bytes(16)); // Generate a random token (32 characters)
            $stmt = $pdo->prepare("UPDATE user SET token = ? WHERE id = ?");
            $stmt->execute([$token, $user["id"]]);

            // Set the token in the response and return the user data
            $user["token"] = $token;
            $user["status"] = "success";
            echo json_encode($user);
        } else {
            http_response_code(400);
            echo json_encode(["errorMessage" => "Invalid password OR User not found"]);
        }
    }
}





function change_password($input) {
    global $pdo;

    if (empty($input["id"])) {
        http_response_code(400);
        echo json_encode("User ID is required");

    } else if (empty($input["token"])) {
        http_response_code(400);
        echo json_encode("Token required");

    } else if (empty($input["old_password"])) {
        http_response_code(400);
        echo json_encode("Old password field is required");

    } else if (empty($input["new_password"])) {
        http_response_code(400);
        echo json_encode("New password field is required");

    } else if (authorized($input["id"], $input["token"])) {
        // Hash the new password and update it in the database
        $new_password = password_hash($input["new_password"], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $input["id"]]);
        echo json_encode(["status" => "success", "successMessage" => "Password changed successfully"]);

    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "errorMessage" => "Invalid data provided"]);
    }
}




function movies_own($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT movies.* FROM movies 
                           JOIN user_own ON movies.id = user_own.movie_id
                           JOIN user on user.id = user_own.user_id
                           WHERE user_own.user_id = ?");
    $stmt->execute([$id]);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($movies) {
        echo json_encode($movies);
    } else {
        http_response_code(404);
        echo json_encode(["errorMessage" => "No movies found for this user"]);
    }
}

function add_movie_to_user($input) {
    global $pdo;

    if (!isset($input["user_id"]) || !isset($input["movie_id"]) || !isset($input["token"])) {
        http_response_code(400);
        echo json_encode(["errorMessage" => "Paramètres manquants: user_id, movie_id et token sont requis"]);
        return;
    }

    $userId = $input["user_id"];
    $movieId = $input["movie_id"];
    $token = $input["token"];

    $stmt = $pdo->prepare("SELECT id FROM user WHERE id = ? AND token = ?");
    $stmt->execute([$userId, $token]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(401);
        echo json_encode(["errorMessage" => "Authentification échouée"]);
        return;
    }

    $stmt = $pdo->prepare("SELECT id FROM movies WHERE id = ?");
    $stmt->execute([$movieId]);
    $movie = $stmt->fetch();

    if (!$movie) {
        http_response_code(404);
        echo json_encode(["errorMessage" => "Film non trouvé"]);
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM user_own WHERE user_id = ? AND movie_id = ?");
    $stmt->execute([$userId, $movieId]);
    $existingRecord = $stmt->fetch();

    if ($existingRecord) {
        http_response_code(409); // Conflit
        echo json_encode(["errorMessage" => "L'utilisateur possède déjà ce film"]);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO user_own (user_id, movie_id) VALUES (?, ?)");
    $result = $stmt->execute([$userId, $movieId]);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Film ajouté avec succès"]);
    } else {
        http_response_code(500);
        echo json_encode(["errorMessage" => "Erreur lors de l'ajout du film"]);
    }
}

?>