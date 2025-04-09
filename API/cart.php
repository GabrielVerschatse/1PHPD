<?php

require_once 'connection_bdd.php';


// Handle GET requests
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $headers = getallheaders();
    $id = isset($headers['user_id']) ? $headers['user_id'] : '';
    $token = isset($headers['token']) ? $headers['token'] : '';
    $input = [
        "user_id" => $id,
        "token" => $token
    ];
    get_cart($input);

} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    if ($input["action"] == "add_cart") {
        add_cart($input);
    } else {
        http_response_code(400);
        echo json_encode("Invalid action");
    }

} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $url = $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);                      // Transform the URL into an array
    parse_str($url_components['query'], $input);    // Transform the array into a dictionary
    delete_movie($input);

} else {
    http_response_code(400);
    echo json_encode("Invalid Method");
}








function get_cart($input) {
    global $pdo;

    // Check if required fields are empty
    if (empty($input["user_id"])) {
        http_response_code(400);
        echo json_encode("ID is required");

    } elseif (empty($input["token"])) {
        http_response_code(400);
        echo json_encode("Token is required");


    } elseif (authorized($input["user_id"], $input["token"])) {
        // We are authorized, acquire the cart
        $stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
        $stmt->execute([$input["user_id"]]);

        if ($stmt->rowCount() > 0) {
            $cart_id = $stmt->fetch()["id"];
            // Join tables for cart content
            $stmt = $pdo->prepare("SELECT title, actors, directors, price, video
                                          FROM cart_content
                                          JOIN movies ON cart_content.movie_id = movies.id
                                          WHERE cart_content.cart_id = ?");
            $stmt->execute([$cart_id]);
            $cart_content = $stmt->fetchAll();
            if ($cart_content) {
                echo json_encode($cart_content);

            } else {
                http_response_code(404);
                echo json_encode("Cart is empty");
            }
        } else {
            http_response_code(404);
            echo json_encode("Cart not created yet, need to add a product once to create it");
        }
    } else {
        http_response_code(401);
        echo json_encode("Unauthorized");
    }
}









function add_cart($input) {
    global $pdo;

    // Check if required fields are empty
    if (empty($input["user_id"])) {
        http_response_code(400);
        echo json_encode("User ID is required");

    } elseif (empty($input["token"])) {
        http_response_code(400);
        echo json_encode("Token is required");

    } elseif (empty($input["movie_id"])) {
        http_response_code(400);
        echo json_encode("Movie ID is required");

    } elseif (authorized($input["user_id"], $input["token"])) {
        // We are authorized, check if the client already got a cart
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$input["user_id"]]);

        if ($stmt->rowCount() > 0) {
            // The user already has a cart, we can add the product to it
            $cart_id = $stmt->fetch()["id"];
            $stmt = $pdo->prepare("INSERT INTO cart_content (cart_id, movie_id) VALUES (?, ?)");
            $stmt->execute([$cart_id, $input["movie_id"]]);
            echo json_encode("Product added to cart");

        } else {
            // The user doesn't have a cart, we need to create one
            $stmt = $pdo->prepare("INSERT INTO cart (user_id) VALUES (?)");
            $stmt->execute([$input["user_id"]]);
            $cart_id = $pdo->lastInsertId();

            // Now we can add the product to the new cart
            $stmt = $pdo->prepare("INSERT INTO cart_content (cart_id, movie_id) VALUES (?, ?)");
            $stmt->execute([$cart_id, $input["movie_id"]]);
            echo json_encode("Product added to new cart");
        }

    } else {
        http_response_code(401);
        echo json_encode("Unauthorized");
    }
}







function delete_movie($input) {
    global $pdo;

    // Check if required fields are empty
    if (empty($input["user_id"])) {
        http_response_code(400);
        echo json_encode("User ID is required");

    } elseif (empty($input["token"])) {
        http_response_code(400);
        echo json_encode("Token is required");

    } elseif (empty($input["movie_id"])) {
        http_response_code(400);
        echo json_encode("Movie ID is required");

    } elseif (authorized($input["user_id"], $input["token"])) {
        // We are authorized, check if the client already got a cart
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$input["user_id"]]);

        if ($stmt->rowCount() > 0) {
            // The user already has a cart, we can add the product to it
            $cart_id = $stmt->fetch()["id"];
            $stmt = $pdo->prepare("DELETE FROM cart_content WHERE cart_id = ? AND movie_id = ?");
            $stmt->execute([$cart_id, $input["movie_id"]]);
            echo json_encode("Product deleted from cart");

        } else {
            http_response_code(404);
            echo json_encode("Cart not created yet, need to add a product once to create it");
        }

    } else {
        http_response_code(401);
        echo json_encode("Unauthorized");
    }
}

?>