<?php
require_once '../../config/db.php';

$articles = $pdo->query("
  SELECT a.*, c.nom AS categorie
  FROM articles a
  LEFT JOIN categories c ON a.categorie_id = c.id
  ORDER BY a.date_pub DESC
")->fetchAll();
?>


<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Gestion des articles</h1>

<a href="add.php" class="btn btn-add">+ Ajouter</a>

<table>
  <tr>
    <th>ID</th>
    <th>Image</th>
    <th>Titre</th>
    <th>Catégorie</th>
    <th>Date</th>
    <th>Actions</th>
  </tr>

  <?php foreach($articles as $a): ?>
  <tr>
    <td><?= $a['id'] ?></td>
    <td>
            <img src="../uploads/articles/<?php echo $a['image']; ?>" width="120">
        </td>
    <td><?= htmlspecialchars($a['titre']) ?></td>
    <td><?= htmlspecialchars($a['categorie']) ?></td>
    <td><?= $a['date_pub'] ?></td>
    <td>
            <a href="edit.php?id=<?php echo $a['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="delete.php?id=<?php echo $a['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer ce service ?');">
               Supprimer
            </a>
        </td>
  </tr>
  <?php endforeach; ?>
</table>

<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
