<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

// Vérification connexion
if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/admin/login.php");
    exit();
}

// Vérification Super Admin
if ($_SESSION['admin_role'] != 'super_admin') {
    header("Location: /StandComputer/tableau-de-bord");
    exit();
}

// Liste des administrateurs
$stmt = $pdo->query("SELECT * FROM admins ORDER BY id ASC");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>

<meta charset="UTF-8">
<title>Gestion des administrateurs</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

<style>

body{
    margin:0;
    background:#f5f7fb;
    font-family:Poppins,sans-serif;
}

.container{

    width:95%;
    max-width:1200px;
    margin:40px auto;

}

.header{

display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;

}

.header h2{

margin:0;
color:#0F172A;

}

.btn-add{

background:#FF6B00;
color:white;
padding:12px 20px;
text-decoration:none;
border-radius:8px;
font-weight:600;

}

.btn-add:hover{

opacity:.9;

}

table{

width:100%;
border-collapse:collapse;
background:white;
border-radius:12px;
overflow:hidden;
box-shadow:0 5px 20px rgba(0,0,0,.08);

}

th{

background:#1565C0;
color:white;
padding:15px;

}

td{

padding:15px;
text-align:center;
border-bottom:1px solid #eee;

}

.role{

padding:5px 10px;
border-radius:30px;
font-size:.75rem;
font-weight:600;

}

.super{

background:#ffe7c8;
color:#d65c00;

}

.admin{

background:#dbeafe;
color:#1565C0;

}

.active{

color:green;
font-weight:600;

}

.inactive{

color:red;
font-weight:600;

}

.actions{

display:flex;
justify-content:center;
gap:10px;

}

.actions a{

text-decoration:none;
padding:7px 12px;
border-radius:6px;
font-size:.8rem;
font-weight:500;

}

.edit{

background:#1565C0;
color:white;

}

.status{

background:#f4b400;
color:white;

}

.delete{

background:#dc2626;
color:white;

}

</style>

</head>
<body>

<div class="container">

<div class="header">

<h2>Gestion des administrateurs</h2>

<a class="btn-add"
href="/StandComputer/ajouter-un-administrateur">

+ Ajouter un administrateur

</a>

</div>

<table>

<tr>

<th>ID</th>
<th>Nom</th>
<th>Nom utilisateur</th>
<th>Rôle</th>
<th>Statut</th>
<th>Créé le</th>
<th>Actions</th>

</tr>

<?php foreach($admins as $admin): ?>

<tr>

<td><?= $admin['id'] ?></td>

<td><?= htmlspecialchars($admin['nom']) ?></td>

<td><?= htmlspecialchars($admin['username']) ?></td>

<td>

<?php if($admin['role']=="super_admin"): ?>

<span class="role super">

Super Admin

</span>

<?php else: ?>

<span class="role admin">

Administrateur

</span>

<?php endif; ?>

</td>

<td>

<?php if($admin['actif']): ?>

<span class="active">Actif</span>

<?php else: ?>

<span class="inactive">Inactif</span>

<?php endif; ?>

</td>

<td>

<?= date('d/m/Y',strtotime($admin['created_at'])) ?>

</td>

<td>

<div class="actions">

<a
class="edit"
href="/StandComputer/modifier-un-administrateur?id=<?= $admin['id'] ?>">

Modifier

</a>

<?php
if($admin['id'] != $_SESSION['admin_id']):
?>

<a
class="status"
href="/StandComputer/changer-le-statut-dun-administrateur?id=<?= $admin['id'] ?>">

<?= $admin['actif'] ? "Désactiver" : "Activer"; ?>

</a>

<a
class="delete"
onclick="return confirm('Supprimer cet administrateur ?');"
href="/StandComputer/supprimer-un-administrateur?id=<?= $admin['id'] ?>">

Supprimer

</a>

<?php endif; ?>

</div>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>