<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$realisations = $pdo->query("
    SELECT * FROM realisations
    ORDER BY created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Gestion des Réalisations</h1>

<a href="add.php" class="btn btn-add">+ Ajouter</a>
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
            <img src="../uploads/realisations/<?php echo $real['thumbnail']; ?>" width="120">
        </td>

        <td><?php echo htmlspecialchars($real['title']); ?></td>

        <td><?php echo htmlspecialchars($real['category']); ?></td>

        <td>
            <a href="edit.php?id=<?php echo $real['id']; ?>" class="btn btn-edit">Modifier</a>
            <a href="upload_images.php?id=<?php echo $real['id']; ?>" class="btn btn-add">Images</a>

            <a href="delete.php?id=<?php echo $real['id']; ?>"
               class="btn btn-delete"
               onclick="return confirm('Supprimer cette réalisation ?')">
               Supprimer
            </a>
        </td>

    </tr>
    <?php endforeach; ?>

</table>