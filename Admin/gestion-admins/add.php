<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/admin/login.php");
    exit();
}

if ($_SESSION['admin_role'] != 'super_admin') {
    header("Location: /StandComputer/tableau-de-bord");
    exit();
}

$error = "";
$success = "";

if(isset($_POST['save'])){

    $nom       = trim($_POST['nom']);
    $username  = trim($_POST['username']);
    $password  = trim($_POST['password']);
    $confirm   = trim($_POST['confirm']);
    $role      = $_POST['role'];

    if(empty($nom) || empty($username) || empty($password)){

        $error = "Veuillez remplir tous les champs.";

    }elseif($password != $confirm){

        $error = "Les mots de passe ne correspondent pas.";

    }else{

        // Vérifier le username
        $check = $pdo->prepare("SELECT id FROM admins WHERE username=?");
        $check->execute([$username]);

        if($check->rowCount()){

            $error = "Ce nom d'utilisateur existe déjà.";

        }else{

            $insert = $pdo->prepare("
                INSERT INTO admins
                (nom,username,passwor,role,actif)
                VALUES(?,?,?,?,1)
            ");

            $insert->execute([
                $nom,
                $username,
                $password,
                $role
            ]);

            $success = "Administrateur ajouté avec succès.";

        }

    }

}
?>

<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<title>Ajouter un administrateur</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{

background:#f5f7fb;
font-family:Poppins,sans-serif;

}

.container{

width:600px;
margin:50px auto;
background:white;
padding:35px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.1);

}

h2{

margin-bottom:25px;

}

input,
select{

width:100%;
padding:13px;
margin-top:8px;
margin-bottom:20px;
border:1px solid #ddd;
border-radius:8px;
font-family:Poppins;

}

button{

background:#FF6B00;
color:white;
border:none;
padding:13px 22px;
border-radius:8px;
cursor:pointer;
font-weight:600;

}

.success{

background:#d1fae5;
padding:12px;
border-radius:8px;
margin-bottom:20px;
color:#065f46;

}

.error{

background:#fee2e2;
padding:12px;
border-radius:8px;
margin-bottom:20px;
color:#991b1b;

}

</style>

</head>

<body>

<div class="container">

<h2>Ajouter un administrateur</h2>

<?php if($error): ?>

<div class="error">

<?= $error; ?>

</div>

<?php endif; ?>

<?php if($success): ?>

<div class="success">

<?= $success; ?>

</div>

<?php endif; ?>

<form method="POST">

<label>Nom complet</label>

<input
type="text"
name="nom"
required>

<label>Nom d'utilisateur</label>

<input
type="text"
name="username"
required>

<label>Mot de passe</label>

<input
type="password"
name="password"
required>

<label>Confirmer le mot de passe</label>

<input
type="password"
name="confirm"
required>

<label>Rôle</label>

<select name="role">

<option value="admin">
Administrateur
</option>

<option value="super_admin">
Super Administrateur
</option>

</select>

<button
type="submit"
name="save">

Créer l'administrateur

</button>

</form>

</div>

</body>

</html>