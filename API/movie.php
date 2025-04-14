<?php

require_once 'connection_bdd.php';

// Handle GET requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['search']) || isset($_GET['genre']) || isset($_GET['sort'])) {
        $search_term = isset($_GET['search']) ? $_GET['search'] : '';
        search_movies($search_term);
    } else {
        $headers = getallheaders();
        $id = isset($headers['user_id']) ? $headers['user_id'] : '';
        $token = isset($headers['token']) ? $headers['token'] : '';
        $input = [
            "user_id" => $id,
            "token" => $token
        ];
        get_cart($input);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input || !is_array($input)) {
        http_response_code(400);
        echo json_encode("Invalid input format");
        exit;
    }

    if (isset($input["action"]) && $input["action"] == "add_cart") {
        if (!isset($input['user_id']) || !isset($input['movie_id']) || !isset($input['token'])) {
            http_response_code(400);
            echo json_encode("Missing required parameters");
            exit;
        }
        add_cart($input);
    } else {
        http_response_code(400);
        echo json_encode("Invalid action");
    }
} else {
    http_response_code(400);
    echo json_encode("Invalid Method");
}

function search_movies($search_term) {
    global $pdo;

    $search = "%" . trim($search_term) . "%";
    $params = [$search, $search, $search, $search, $search, $search];

    $sql = "SELECT DISTINCT movies.*
            FROM movies
            LEFT JOIN movies_actor ON movies.id = movies_actor.movie_id
            LEFT JOIN actor ON movies_actor.actor_id = actor.id
            LEFT JOIN movies_director ON movies.id = movies_director.movie_id
            LEFT JOIN director ON movies_director.director_id = director.id
            WHERE (movies.title LIKE ?
            OR actor.firstname LIKE ?
            OR actor.lastname LIKE ?
            OR director.firstname LIKE ?
            OR director.lastname LIKE ?)";

    if (isset($_GET['genre']) && $_GET['genre'] !== '') {
        $sql .= " AND movies.genre LIKE ?";
        $params[] = "%" . $_GET['genre'] . "%";
    }

    if (isset($_GET['sort']) && $_GET['sort'] === 'old') {
        $sql .= " ORDER BY movies.release_date ASC";
    } else {
        $sql .= " ORDER BY movies.release_date DESC";
    }

    $sql .= " LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        header('Content-Type: application/json');
        echo json_encode($results);
    } else {
        http_response_code(404);
        echo json_encode('Aucun film trouvé');
    }
}

function add_cart($input) {
    global $pdo;

    $user_id = $input['user_id'];
    $movie_id = $input['movie_id'];
    $token = $input['token'];

    if (!is_user_authenticated($user_id, $token)) {
        http_response_code(401);
        echo json_encode('Utilisateur non authentifié');
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND movie_id = ?");
    $stmt->execute([$user_id, $movie_id]);
    $existing_cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_cart_item) {
        http_response_code(400);
        echo json_encode('Le film est déjà dans le panier');
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO cart (user_id, movie_id) VALUES (?, ?)");
    if ($stmt->execute([$user_id, $movie_id])) {
        http_response_code(200);
        echo json_encode('Film ajouté au panier');
    } else {
        http_response_code(500);
        echo json_encode('Erreur lors de l\'ajout du film au panier');
    }
}

function get_cart($input) {
    global $pdo;

    $user_id = $input['user_id'];
    $token = $input['token'];

    if (!is_user_authenticated($user_id, $token)) {
        http_response_code(401);
        echo json_encode('Utilisateur non authentifié');
        return;
    }

    $stmt = $pdo->prepare("SELECT movies.*, cart.id AS cart_id
                            FROM cart
                            LEFT JOIN movies ON cart.movie_id = movies.id
                            WHERE cart.user_id = ?");
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cart_items) > 0) {
        header('Content-Type: application/json');
        echo json_encode($cart_items);
    } else {
        http_response_code(404);
        echo json_encode('Aucun film dans le panier');
    }
}

function is_user_authenticated($user_id, $token) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND token = ?");
    $stmt->execute([$user_id, $token]);
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}
?>