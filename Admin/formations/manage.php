<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/connexion");
    exit();
}

$formations = $pdo->query("SELECT * FROM formations")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Gestion des Formations</h1>
<br>
<br>

<a href="/StandComputer/ajouter-une-formation" class="btn btn-add">+ Ajouter</a>
<br>
<br>
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
            
            <img src="/StandComputer/admin/uploads/formations/<?php echo $formation['image']; ?>" width="80">
        </td>

        <td><?php echo htmlspecialchars($formation['title']); ?></td>

        <td><?php echo htmlspecialchars($formation['niveau']); ?></td>
                <td><?php echo htmlspecialchars($formation['intitule']); ?></td>
        <td><?php echo htmlspecialchars($formation['description']); ?></td>
            <td><?php echo htmlspecialchars($formation['nombrePersonne']); ?></td>
            <td><?php echo htmlspecialchars($formation['natureDiplome']); ?></td>

        <td><?php echo htmlspecialchars($formation['duration']); ?></td>

        <td>
            <a href="/StandComputer/modifier-cette-formation?id=<?php echo $formation['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="/StandComputer/supprimer-formation?id=<?php echo $formation['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer cette formation ?');">
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

