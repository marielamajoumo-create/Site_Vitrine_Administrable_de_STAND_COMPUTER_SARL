<?php
session_start();
include '../../config/db.php';

$horaires = $pdo->query("SELECT * FROM horaires ORDER BY id DESC")
                ->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Horaires</h1>

<a href="add.php" class="btn btn-add">+ Ajouter</a>

<table>
    <tr>
        <th>Jour</th>
        <th>Horaires</th>
        <th>Actions</th>
    </tr>

    <?php foreach($horaires as $h): ?>
    <tr>
        <td><?= $h['jour'] ?></td>
        <td><?= $h['ouvertureFermeture'] ?></td>

        <td>
            <a href="edit.php?id=<?= $h['id'] ?>" class="btn btn-edit">Modifier</a>
            <a href="delete.php?id=<?= $h['id'] ?>"
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
