<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
$stmt->execute([$id]);

header("Location: /StandComputer/gerer-les-articles");