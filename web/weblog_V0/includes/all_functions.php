<?php
include('config.php');

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
}

function getTopics(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM topics";
    $result = $conn->query($sql);
    return $result;
}
?>