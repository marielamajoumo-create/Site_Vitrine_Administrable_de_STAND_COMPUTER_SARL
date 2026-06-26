<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'];

$pdo->prepare("DELETE FROM horaires WHERE id=?")->execute([$id]);

header("Location: /StandComputer/gerer-les-horaires");
exit();