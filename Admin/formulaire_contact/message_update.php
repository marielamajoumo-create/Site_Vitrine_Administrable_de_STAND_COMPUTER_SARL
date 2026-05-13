<?php
require_once __DIR__ . '/../../config/db.php';

    $id = $_GET['id'] ?? null;
    $statut = $_GET['statut'] ?? null;

if ($id && $statut) {
    $sql = "UPDATE messages SET statut = :statut WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':statut' => $statut, ':id' => $id]);
}

header("Location: manage.php");
exit;
?>
