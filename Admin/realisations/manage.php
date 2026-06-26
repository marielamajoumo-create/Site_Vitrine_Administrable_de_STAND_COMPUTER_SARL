<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$realisations = $pdo->query("
    SELECT * FROM realisations
    ORDER BY created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Gestion des Réalisations</h1>

<a href="/StandComputer/ajouter-une-realisation" class="btn btn-add">+ Ajouter</a>
<br/>
<br/>
<table>
    <tr>
        <th>ID</th>
        <th>Thumbnail</th>
        <th>Titre</th>
        <th>Catégorie</th>
        <th>Actions</th>
    </tr>

    <?php foreach($realisations as $real): ?>
    <tr>

        <td><?php echo $real['id']; ?></td>

        <td>
            <img src="/StandComputer/admin/uploads/realisations/<?php echo $real['thumbnail']; ?>" width="120">
        </td>

        <td><?php echo htmlspecialchars($real['title']); ?></td>

        <td><?php echo htmlspecialchars($real['category']); ?></td>

        <td>
            <a href="/StandComputer/modifier-cette-realisation?id=<?php echo $real['id']; ?>" class="btn btn-edit">Modifier</a>
            <a href="/StandComputer/modifier-les-images-de-cette-realisation?id=<?php echo $real['id']; ?>" class="btn btn-add">Images</a>
            <!-- Gestion des vidéos -->
            <a href="/StandComputer/modifier-les-videos-de-cette-realisation?id=<?php echo $real['id']; ?>" class="btn btn-add">
                Vidéos
            </a>

            <a href="/StandComputer/supprimer-realisation?id=<?php echo $real['id']; ?>"
               class="btn btn-delete"
               onclick="return confirm('Supprimer cette réalisation ?')">
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
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
