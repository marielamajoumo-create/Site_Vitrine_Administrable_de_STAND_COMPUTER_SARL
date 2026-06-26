<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $del = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $del->execute([$id]);
}

header("Location: /StandComputer/gerer-les-categories");
exit();