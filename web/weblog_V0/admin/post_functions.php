<?php

// Connexion à la base de données
include "../config.php";

// Déclare les variables utilisées dans create_post.php
$title = "";
$body = "";
$slug = "";
$featured_image = "";
$isEditingPost = false;
$post_id = 0;




if (isset($_POST['create_post'])) {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $title = esc($_POST['title']);
    $body = esc($_POST['body']);
    $published = isset($_POST['published']) ? 1 : 0;
    $topic_id = esc($_POST['topic_id']);
    $user_id = isset($_SESSION['user']['id']) ? intval($_SESSION['user']['id']) : 1;
    $slug = strtolower(str_replace(' ', '-', $title));

    // Image
    $image = $_FILES['featured_image']['name'];
    $target = "../static/images/" . basename($image);

    if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
        // CREATION DU POST
        $query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, updated_at) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("issssi", $user_id, $title, $slug, $image, $body, $published);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        // ASSIGNATION DU TOPIC AU POST
        $post_id = $stmt->insert_id;

        $query_topic = "INSERT INTO post_topic (post_id, topic_id) VALUES (?, ?)";
        $stmt_topic = $conn->prepare($query_topic);
        $stmt_topic->bind_param("ii", $post_id, $topic_id);

        if (!$stmt_topic->execute()) {
            die("Execute failed (post_topic): " . $stmt_topic->error);
        }


        //exit();
    } else {
        $errors[] = "Failed to upload image.";
    }
}

if (isset($_POST['update_post'])) {
    updatePost($_POST);
}




function getPost($post_id)
{
    global $conn;
    $query = "SELECT * FROM posts WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonction pour échapper les données
function esc($value)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($value));
}

