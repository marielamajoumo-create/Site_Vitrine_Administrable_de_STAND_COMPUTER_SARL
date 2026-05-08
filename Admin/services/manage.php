<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Gestion des Services</h1>

<a href="add.php" class="btn btn-add">+ Ajouter</a>

<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Icone</th>
        <th>Categorie</th>
        <th>Titre</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($services as $service): ?>
    <tr>
        <td><?php echo $service['id']; ?></td>
        <td>
            <img src="../uploads/services/<?php echo $service['image']; ?>" width="120">
        </td>

        <td>
            <?php echo htmlspecialchars($service['icon']); ?>
        </td>
        <td><?php echo htmlspecialchars($service['category']); ?></td>
        <td><?php echo htmlspecialchars($service['title']); ?></td>

        <td><?php echo htmlspecialchars($service['description']); ?></td>

        <td>
            <a href="edit.php?id=<?php echo $service['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="delete.php?id=<?php echo $service['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer ce service ?');">
               Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

