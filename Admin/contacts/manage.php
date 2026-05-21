<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$contacts = $pdo->query("SELECT * FROM contacts ORDER BY id DESC")
                ->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Contacts</h1>

<a href="add.php" class="btn btn-add">+ Ajouter</a>

<table>
    <tr>
        <th>Téléphone</th>
        <th>Email</th>
        <th>WhatsApp</th>
        <th>Localisation</th>
        <th>Actions</th>
    </tr>

    <?php foreach($contacts as $c): ?>
    <tr>
        <td><?= $c['phone'] ?></td>
        <td><?= $c['email'] ?></td>
        <td><?= $c['whatsapp'] ?></td>
        <td><?= $c['localisation'] ?></td>

        <td>
            <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-edit">Modifier</a>
            <a href="delete.php?id=<?= $c['id'] ?>"
             class="btn btn-delete"
               onclick="return confirm('Supprimer ?')">
               Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<a href="/StandComputer/tableau-de-bord" class="back">
                Retour au tableau de bord 
            </a>