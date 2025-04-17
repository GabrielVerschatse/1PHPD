<?php

require_once 'connection_bdd.php';

// Handle GET requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Look for the main research parameter (either title, actor, or director)
    if (isset($_GET['title']) && !empty($_GET['title'])) {
        $search_term = explode("?", $_GET['title']);
        $type = 'title';
        search_movies($search_term, $type);
    } elseif (isset($_GET['actor']) && !empty($_GET['actor'])) {
        $search_term = explode("?", $_GET['actor']);
        $type = 'actor';
        search_movies($search_term, $type);
    } elseif (isset($_GET['director']) && !empty($_GET['director'])) {
        $search_term = explode("?", $_GET['director']);
        $type = 'director';
        search_movies($search_term, $type);
    } elseif (isset($_GET['genre'])) {
        $genre = $_GET['genre'];
        movies_genre($genre);
    } else{
        http_response_code(400);
        echo json_encode('Pas de paramètres de recherche');
    }

}

function search_movies($search_term, $type) {
    global $pdo;

    if ($type === 'title') {
        $sql = "SELECT DISTINCT movies.*
                FROM movies
                WHERE movies.title LIKE :main_param";
    } elseif ($type === 'actor') {
        $sql = "SELECT DISTINCT movies.*
                FROM movies
                JOIN movies_actor ON movies.id = movies_actor.movie_id
                JOIN actor ON movies_actor.actor_id = actor.id
                WHERE actor.firstname LIKE :main_param OR actor.lastname LIKE :main_param";
    } else {
        $sql = "SELECT DISTINCT movies.*
                FROM movies
                JOIN movies_director ON movies.id = movies_director.movie_id
                JOIN director ON movies_director.director_id = director.id
                WHERE director.firstname LIKE :main_param OR director.lastname LIKE :main_param";
    }


    $sql .= " AND movies.genre LIKE :genre";

    if ($search_term[2] === 'old') {
        $sql .= " ORDER BY movies.release_date ASC";
    } else {
        $sql .= " ORDER BY movies.release_date DESC";
    }

    $sql .= " LIMIT 20";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [
            ':main_param' => '%' . $search_term[0] . '%',           // Add % wildcards for LIKE
            ':genre' => '%' . $search_term[1] . '%'
        ]
    );
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        header('Content-Type: application/json');
        echo json_encode($results);
    } else {
        http_response_code(404);
        echo json_encode('Aucun film trouvé');
    }
}



function movies_genre($genre){
    // Return all movies of a specific genre
    global $pdo;

    $sql = "SELECT DISTINCT movies.*
            FROM movies
            WHERE movies.genre LIKE :genre";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [
            ':genre' => '%' . $genre . '%'
        ]
    );
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