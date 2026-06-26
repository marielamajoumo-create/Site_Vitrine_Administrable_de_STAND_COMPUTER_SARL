<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/connexion");
    exit();
}

$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Gestion des Services</h1>

<a href="/StandComputer/ajouter-un-service" class="btn btn-add">+ Ajouter</a>
<br>
<br>

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
            <img src="/StandComputer/admin/uploads/services/<?php echo $service['image']; ?>" width="120">
        </td>

        <td>
            <?php echo htmlspecialchars($service['icon']); ?>
        </td>
        <td><?php echo htmlspecialchars($service['category']); ?></td>
        <td><?php echo htmlspecialchars($service['title']); ?></td>

        <td><?php echo htmlspecialchars($service['description']); ?></td>

        <td>
            <a href="/StandComputer/modifier-ce-service?id=<?php echo $service['id']; ?>" class="btn btn-edit">Modifier</a>

            <a href="/StandComputer/supprimer-service?id=<?php echo $service['id']; ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer ce service ?');">
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

