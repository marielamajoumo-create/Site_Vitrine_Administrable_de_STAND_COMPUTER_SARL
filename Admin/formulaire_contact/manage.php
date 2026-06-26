<?php
require_once __DIR__ . '/../../config/db.php';


$sql = "SELECT id, nom, email, telephone,sujet, date_creation, statut 
        FROM messages ORDER BY date_creation DESC";
$stmt = $pdo->query($sql);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Messages de contact</h1>
<br>
<br>
<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Sujet</th>
      <th>Date</th>
      <th>Statut</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($messages as $msg): ?>
      <tr>
        <td><?= $msg['id'] ?></td>
        <td><?= htmlspecialchars($msg['nom']) ?></td>
        <td><?= htmlspecialchars($msg['email']) ?></td>
        <td><?= htmlspecialchars($msg['telephone']) ?></td>
        <td><?= htmlspecialchars($msg['sujet']) ?></td>
        <td><?= $msg['date_creation'] ?></td>
        <td><?= $msg['statut'] ?></td>
        <td>
          <a href="/StandComputer/lire?id=<?= $msg['id'] ?>" class ="btn btn-edit">Lire</a> |
          <a href="/StandComputer/lu-repondu?id=<?= $msg['id'] ?> &statut=lu" class ="btn btn-add" >Marquer lu</a> |
          <a href="/StandComputer/lu-repondu?id=<?= $msg['id'] ?> &statut=repondu" class ="btn btn-add">Marquer repondu</a> |
          <a href="/StandComputer/supprimer-message?id=<?= $msg['id'] ?>" class="btn btn-delete"
               onclick="return confirm('Supprimer ce message ?');">
               Supprimer
            </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br>
<br>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>

