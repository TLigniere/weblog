<?php
include('config.php');


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["update_admin"]) ) {
    
    $id = $_POST['admin_id'] ?? '0';
    $oldValues=getAdmin($id);

    $username = $_POST["username"] ?? $oldValues["username"];
    $email = $_POST['email'] ?? $oldValues["email"];
    $role = $_POST['role_id'] ?? $oldValues["role"];
    $password = $_POST['password'] ?? $oldValues["password"];
    $password_confirmation = $_POST['passwordConfirmation'] ?? $oldValues["password"];

    if (isset($id) && isset($username) && isset($email) && isset($role) && isset($password) && ($password==$password_confirmation)) {
        if ($_POST["password"]!=""){
            $hashedPassword = md5($password);
        } else {
            $hashedPassword = $password;
        }
        $now = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, password = ?, updated_at = ? WHERE id=?");
        $stmt->bind_param("ssssss", $username, $email, $role, $hashedPassword, $now, $id);

        if ($stmt->execute()) {
            $_SESSION["message"] = "Utilisateur modifier avec succès";
        } else {
            $_SESSION["message"] = "Erreur lors durant enregistrement :   '$stmt->error'";
        }

        $stmt->close();
    } else {
        $_SESSION["message"] = "Tous les champs sont requis.'$id,$oldValues[username],$oldValues[email],$oldValues[role],$oldValues[password]'";
        //$_SESSION["message"] = "Tous les champs sont requis.'$username,$email,$role,$password,$password_confirmation'";
    }
}



if (isset($_POST["create_admin"]) && !isset($_GET["edit-admin"])) {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['passwordConfirmation'] ?? '';

    if ($username && $email && $role && $password && ($password==$password_confirmation)) {
        $hashedPassword = md5($password);

        $now = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO users (username, email, role, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $role, $hashedPassword, $now, $now);

        if ($stmt->execute()) {
            $_SESSION["message"] = "Utilisateur enregistrer avec succès";
        } else {
            $_SESSION["message"] = "Erreur lors durant enregistrement :   '$stmt->error'";
        }

        $stmt->close();
    } else {
        $_SESSION["message"] = "Tous les champs sont requis.'$username,$email,$role,$password,$password_confirmation'";
    }
}

if (isset($_POST["create_topic"])){
    $name = $_POST["name"];
    $slug = strtolower(str_replace(' ', '-', $name));
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "INSERT INTO topics (name, slug) VALUES ('$name', '$slug')";
    $result = $conn->query($sql);
    if ($result){
        $_SESSION["message"] = "Topic created successfully";
    } else {
        $_SESSION["message"] = "Error creating topic: '$conn->error'";
    }
}

if (isset($_POST["update_topic"])){
    $id = $_POST["topic_id"];
    $name = $_POST["name"];
    $slug = strtolower(str_replace(' ', '-', $name));
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "UPDATE topics SET name='$name', slug='$slug' WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result){
        $_SESSION["message"] = "Topic updated successfully";
    } else {
        $_SESSION["message"] = "Error updating topic: '$conn->error'";
    }
}



if (isset($_GET["delete-admin"])){
    deleteUser($_GET["delete-admin"]);
}

if (isset($_GET["delete-topic"])){
    deleteTopic($_GET["delete-topic"]);
}

if (isset($_GET["delete-post"])){
    deletePost($_GET["delete-post"]);
}

function deleteTopic($id){
    $sql = "DELETE FROM topics WHERE id='$id'";
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $result = $conn->query($sql);
    if ($result){
        return TRUE;
    }
    return FALSE;
    
}

function deletePost($id){
    $sql = "DELETE FROM posts WHERE id='$id'";
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $result = $conn->query($sql);
    if ($result){
        return TRUE;
    } else {
        return FALSE;
    }
}

function getAdminRoles(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT name FROM roles";
    $result = $conn->query($sql);
    $roles=[];
    while ($result_value = $result->fetch_assoc()){
        $roles[]=$result_value["name"];
    }
    return $roles;
}

function getAdmin($id){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM users WHERE id= '$id'" ;
    $query = $conn->query($sql);
    $result = $query->fetch_assoc();
    return $result;
}

function getAdminUsers(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT 
    users.* 
    FROM users
    LEFT JOIN roles ON roles.name = users.role
    ORDER BY users.created_at ASC";

    $result = $conn->query($sql);
    return ($result);
}

function getNumberUsers(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT COUNT(username) AS N_users FROM users";
    $result = $conn->query($sql);
    $N_users = ($result->fetch_assoc())["N_users"];
    return $N_users;
}

function getNumberPosts(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT COUNT(id) AS N_posts FROM posts";
    $result = $conn->query($sql);
    $N_posts = ($result->fetch_assoc())["N_posts"];
    return $N_posts;
}

function getNumberComments(){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT COUNT(id) AS N_comments FROM posts";
    $result = $conn->query($sql);
    $N_comments = ($result->fetch_assoc())["N_comments"];
    return $N_comments;
}

function getTopic($id){
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM topics WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result){
        return $result->fetch_assoc();
    } else {
        return [];
    }
}

function deleteUser($User_id){
    $sql="DELETE FROM users WHERE id='$User_id'";
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $result = $conn->query($sql);
    if ($result){
        return TRUE;
    } else {
        return FALSE;
    }
}



?>
