<?php
require_once '../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage.php");