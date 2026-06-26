<?php
require_once __DIR__ . '/../../config/db.php';

$categories = $pdo->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll();
?>

<link rel="stylesheet" href="/StandComputer/style-admin">
<h1>Gestion des catégories</h1>

<a href="add.php">+ Ajouter</a>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?= $cat['id'] ?></td>
            <td><?= htmlspecialchars($cat['nom']) ?></td>
            <td>
                <a href="/StandComputer/modifier-cette-categorie?id=<?php echo $cat['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="/StandComputer/supprimer-categorie?id=<?php echo $cat['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer cette  categorie ?');">
               Supprimer
            </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<br>

<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
