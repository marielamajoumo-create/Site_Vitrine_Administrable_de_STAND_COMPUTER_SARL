<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'];

$pdo->prepare("DELETE FROM contacts WHERE id=?")->execute([$id]);

header("Location: /StandComputer/gerer-les-contacts");
exit();