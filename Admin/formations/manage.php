<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$formations = $pdo->query("SELECT * FROM formations")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Gestion des Formations</h1>

<a href="../formations/add.php" class="btn btn-add">+ Ajouter</a>

<table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Titre</th>
        <th>Niveau</th>
        <th>Intitule</th>
        <th>Description</th>
        <th>Nombre de personne</th>
        <th> Nature du diplome</th>
        <th> Duree </th>
        <th>Actions</th>
    </tr>

    <?php foreach ($formations as $formation): ?>
    <tr>
        <td><?php echo $formation['id']; ?></td>

        <td>
            <img src="../uploads/<?php echo $formation['image']; ?>" width="80">
        </td>

        <td><?php echo htmlspecialchars($formation['title']); ?></td>

        <td><?php echo htmlspecialchars($formation['niveau']); ?></td>
                <td><?php echo htmlspecialchars($formation['intitule']); ?></td>
        <td><?php echo htmlspecialchars($formation['description']); ?></td>
            <td><?php echo htmlspecialchars($formation['nombrePersonne']); ?></td>
            <td><?php echo htmlspecialchars($formation['natureDiplome']); ?></td>

        <td><?php echo htmlspecialchars($formation['duration']); ?></td>

        <td>
            <a href="edit.php?id=<?php echo $formation['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="delete.php?id=<?php echo $formation['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer cette formation ?');">
               Supprimer
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

