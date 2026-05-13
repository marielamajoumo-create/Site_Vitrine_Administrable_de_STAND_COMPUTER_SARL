<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $msg = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php if ($msg): ?>
  <h2>Message #<?= $msg['id'] ?></h2>
  <p><strong>Nom :</strong> <?= htmlspecialchars($msg['nom']) ?></p>
  <p><strong>Email :</strong> <?= htmlspecialchars($msg['email']) ?></p>
  <p><strong>Téléphone :</strong> <?= htmlspecialchars($msg['telephone']) ?></p>
  <p><strong>Service :</strong> <?= htmlspecialchars($msg['serviceC']) ?></p>
  <p><strong>Sujet :</strong> <?= htmlspecialchars($msg['sujet']) ?></p>
  <p><strong>Message :</strong><br><?= nl2br(htmlspecialchars($msg['messageR'])) ?></p>
  <p><strong>Date :</strong> <?= $msg['date_creation'] ?></p>
  <p><strong>Statut :</strong> <?= $msg['statut'] ?></p>
<?php else: ?>
  <p>Message introuvable ❌</p>
<?php endif; ?>
