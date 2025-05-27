<?php

// Connexion à la base de données
include "../config.php";

// Déclare les variables utilisées dans create_post.php
$title = "";
$body = "";
$topic_id = 0;
$featured_image = "";
$isEditingPost = false;
$post_id = 0;

// Enregistrer un post
if (isset($_POST['create_post'])) {
    createPost($_POST);
}
// Mettre à jour un post
if (isset($_POST['update_post'])) {
    updatePost($_POST);
}

// Récupérer tous les posts avec les infos de l'auteur et du topic
/*
function getAllPosts() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $sql ="SELECT 
    posts.*, 
    topics.name AS topic, 
    users.username AS author
    FROM posts
    LEFT JOIN post_topic ON posts.id = post_topic.post_id

    LEFT JOIN topics ON post_topic.topic_id = topics.id 
    LEFT JOIN users ON posts.user_id = users.id

    ORDER BY posts.created_at DESC";
// Les LEFT JOIN s'assure de lié les posts à leurs topics ainsi que l'utilisateur à ses posts afin de pouvoir retracer entre les clés étrangères.

    $result = $conn->query($sql);
    if ($result){
        return $result;
    }
    return [];
}*/


// Fonction pour créer un post
function createPost($request_values)
{
    global $conn, $errors;

    $title = esc($request_values['title']);
    $body = esc($request_values['body']);
    $topic_id = esc($request_values['topic_id']);
    $user_id = 1; // temporaire : change par l'utilisateur connecté

    // Image
    $image = $_FILES['featured_image']['name'];
    $target = "../static/images/" . basename($image);

    if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $target)) {
        // Enregistrer le post
        $query = "INSERT INTO posts (user_id, title, image, body, topic_id, created_at, updated_at) 
                  VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssi", $user_id, $title, $image, $body, $topic_id);
        $stmt->execute();
        header("Location: posts.php");
        exit();
    } else {
        $errors[] = "Failed to upload image.";
    }
}

// Fonction pour modifier un post
function updatePost($request_values)
{
    global $conn;
    $title = esc($request_values['title']);
    $body = esc($request_values['body']);
    $topic_id = esc($request_values['topic_id']);
    $post_id = esc($request_values['post_id']);
    $image = $_FILES['featured_image']['name'];
    $target = "../static/images/" . basename($image);

    if ($image !== "") {
        move_uploaded_file($_FILES['featured_image']['tmp_name'], $target);
        $query = "UPDATE posts SET title=?, image=?, body=?, topic_id=?, updated_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $title, $image, $body, $topic_id, $post_id);
    } else {
        $query = "UPDATE posts SET title=?, body=?, topic_id=?, updated_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $title, $body, $topic_id, $post_id);
    }

    $stmt->execute();
    header("Location: posts.php");
    exit();
}

// Fonction pour échapper les données
function esc($value)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($value));
}

