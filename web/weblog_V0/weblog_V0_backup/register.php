e<?php
// Connexion à la base de données
include('config.php'); 


$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $email && $role && $password) {
        $hashedPassword = md5($password);

        $now = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO users (username, email, role, password, created_at, updated_at) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $email, $role, $hashedPassword, $now, $now);

        if ($stmt->execute()) {
            echo "Utilisateur enregistré avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Tous les champs sont requis.";
    }
}

$conn->close();
?>

<!-- Formulaire HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrement Utilisateur</title>
    <?php include('includes/public/head_section.php'); ?>
</head>
<body>
<div class="container">

<!-- Navbar -->
<?php include(ROOT_PATH . '/includes/public/navbar.php'); ?>
<!-- // Navbar -->


    <h2>Enregistrement d'un utilisateur</h2>
    <form method="POST" action="">
        <label>Nom d'utilisateur : <input type="text" name="username" required></label><br><br>
        <label>Email : <input type="email" name="email" required></label><br><br>
        <label>Mot de passe : <input type="password" name="password" required></label><br><br>
        <label>Rôle :
            <select name="role" required>
                <option value="Admin">Admin</option>
                <option value="Author">Author</option>
            </select>
        </label><br><br>
        <button type="submit">Enregistrer</button>
    </form>
</div>
</body>
</html>

<?php include(ROOT_PATH . '/includes/public/footer.php'); ?>

