<?php
require_once __DIR__ . '/../../config/db.php';

$articles = $pdo->query("
  SELECT a.*, c.nom AS categorie
  FROM articles a
  LEFT JOIN categories c ON a.categorie_id = c.id
  ORDER BY a.date_pub DESC
")->fetchAll();
foreach ($articles as &$article) {

    $tagStmt = $pdo->prepare("
        SELECT t.nom
        FROM tags t
        INNER JOIN article_tags at
            ON at.tag_id = t.id
        WHERE at.article_id = ?
        ORDER BY t.nom
    ");

    $tagStmt->execute([$article['id']]);

    $article['tags'] = $tagStmt->fetchAll(PDO::FETCH_COLUMN);
}
unset($article);
?>


<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Gestion des articles</h1>
<br/>
<br/>

<a href="/StandComputer/ajouter-un-article" class="btn btn-add">+ Ajouter</a>
<br/>
<br/>

<table>
  <tr>
    <th>ID</th>
   <th>Image</th>
   <th>Titre</th>
   <th>Catégorie</th>
   <th>Tags</th>
   <th>Date</th>
   <th>Actions</th>
  </tr>

  <?php foreach($articles as $a): ?>
  <tr>
    <td><?= $a['id'] ?></td>
    <td>
            <img src="/StandComputer/admin/uploads/articles/<?php echo $a['image']; ?>" width="120">
        </td>
    <td><?= htmlspecialchars($a['titre']) ?></td>
    <td><?= htmlspecialchars($a['categorie']) ?></td>
    <td>

<?php if (!empty($a['tags'])): ?>

    <?= htmlspecialchars(implode(', ', $a['tags'])) ?>

<?php else: ?>

    —

<?php endif; ?>

</td>
    <td><?= $a['date_pub'] ?></td>
    <td>
            <a href="/StandComputer/modifier-cet-article?id=<?php echo $a['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="/StandComputer/supprimer-article?id=<?php echo $a['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer cet article ?');">
               Supprimer
            </a>
        </td>
  </tr>
  <?php endforeach; ?>
</table>

<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
