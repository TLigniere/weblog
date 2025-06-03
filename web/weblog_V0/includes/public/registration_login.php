<?php
include('config.php'); 


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["login_btn"])) {
    // Récupération sécurisée des champs
    $username = $conn->real_escape_string($_POST['username'] ?? '');
    $password = $conn->real_escape_string(md5($_POST['password'] ?? ''));

    if ($username && $password) {
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        // Débogage
        // echo "Requête : $sql<br>";
        // echo "Username : $username<br>";
        // echo "Mot de passe (hashé) : " . md5($_POST['password']) . "<br>";
        
        $result_value = $result->fetch_assoc();

        if ($result_value["password"] && $result_value["username"]) {
            $_SESSION["user"]["username"] = $username;
            $_SESSION['user']['id'] = $result_value["id"];
            $_SESSION["user"]["role"] = $result_value["role"];
            
            echo("<meta http-equiv='refresh' content='1'>");
            $_SESSION["message"] = "Bienvenue sur votre session '$username','$id'";
            //echo '<script type="text/JavaScript"> window.location.reload()</script>';


            //header("Refresh:0");
            //header("Refresh:0");
            //exit();
            //header("Refresh:0");

        } else {
            $_SESSION["message"] = "Nom d'utilisateur ou mot de passe incorrect";
        }
    } else {
        $_SESSION["message"] = "Veuillez remplir tous les champs de connexion";
    }
}

?>