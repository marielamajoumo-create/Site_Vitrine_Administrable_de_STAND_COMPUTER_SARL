<?php
require_once __DIR__ . '/../../config/db.php';

 $id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM messages WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

header("Location: manage.php");
exit;
?>
