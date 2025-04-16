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

    if (!empty($search_term)) {
        $search = "%" . trim($search_term) . "%";

        if (isset($_GET['search_type'])) {
            $search_type = $_GET['search_type'];

            if ($search_type === 'title') {
                $sql = "SELECT DISTINCT movies.*
                        FROM movies
                        WHERE movies.title LIKE ?
                        LIMIT 20";
                $params = [$search];
            }
            elseif ($search_type === 'actor') {
                $sql = "SELECT DISTINCT movies.*
                        FROM movies
                        JOIN movies_actor ON movies.id = movies_actor.movie_id
                        JOIN actor ON movies_actor.actor_id = actor.id
                        WHERE actor.firstname LIKE ? OR actor.lastname LIKE ?
                        LIMIT 20";
                $params = [$search, $search];
            }
            elseif ($search_type === 'director') {
                $sql = "SELECT DISTINCT movies.*
                        FROM movies
                        JOIN movies_director ON movies.id = movies_director.movie_id
                        JOIN director ON movies_director.director_id = director.id
                        WHERE director.firstname LIKE ? OR director.lastname LIKE ?
                        LIMIT 20";
                $params = [$search, $search];
            }
        }
        else {
            $sql = "SELECT DISTINCT movies.*
                FROM movies
                WHERE movies.title LIKE ?
                
                UNION
                
                SELECT DISTINCT movies.*
                FROM movies
                JOIN movies_actor ON movies.id = movies_actor.movie_id
                JOIN actor ON movies_actor.actor_id = actor.id
                WHERE actor.firstname LIKE ? OR actor.lastname LIKE ?
                
                UNION
                
                SELECT DISTINCT movies.*
                FROM movies
                JOIN movies_director ON movies.id = movies_director.movie_id
                JOIN director ON movies_director.director_id = director.id
                WHERE director.firstname LIKE ? OR director.lastname LIKE ?
                
                LIMIT 20";

            $params = [$search, $search, $search, $search, $search];
        }
    }
    else {
        $sql = "SELECT DISTINCT movies.* FROM movies WHERE 1=1";
        $params = [];

        if (isset($_GET['genre']) && !empty($_GET['genre'])) {
            $sql .= " AND movies.genre LIKE ?";
            $params[] = "%" . $_GET['genre'] . "%";
        }

        if (isset($_GET['sort']) && $_GET['sort'] === 'old') {
            $sql .= " ORDER BY movies.release_date ASC";
        } else {
            $sql .= " ORDER BY movies.release_date DESC";
        }

        $sql .= " LIMIT 20";
    }

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
?>