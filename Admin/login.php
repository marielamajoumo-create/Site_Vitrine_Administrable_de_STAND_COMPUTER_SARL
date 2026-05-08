
<?php
session_start();
include '../config/db.php';

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=? AND passwor=?");
    $stmt->execute([$username, $password]);

    if($stmt->rowCount() > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
    } else {
        echo "Identifiants incorrects";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Nom d'utilisateur">
    <input type="password" name="password" placeholder="Mot de passe">
    <button type="submit" name="login">Connexion</button>
</form>

