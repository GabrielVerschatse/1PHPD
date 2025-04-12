<?php

require_once 'connection_bdd.php';


// Handle GET requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        search_movies($_GET['search']);
    }

} else {
    http_response_code(400);
    echo json_encode("Invalid Method");
}

function search_movies($search_term) {
    global $pdo;

    $search = "%" . trim($search_term) . "%";

    $stmt = $pdo->prepare("SELECT DISTINCT movies.*
                          FROM movies
                          LEFT JOIN movies_actor ON movies.id = movies_actor.movie_id
                          LEFT JOIN actor ON movies_actor.actor_id = actor.id
                          LEFT JOIN movies_director ON movies.id = movies_director.movie_id
                          LEFT JOIN director ON movies_director.director_id = director.id
                          WHERE movies.title LIKE ?
                          OR movies.genre LIKE ?
                          OR actor.firstname LIKE ?
                          OR actor.lastname LIKE ?
                          OR director.firstname LIKE ?
                          OR director.lastname LIKE ?
                          LIMIT 20");

    $stmt->execute([$search, $search, $search, $search, $search, $search]);
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