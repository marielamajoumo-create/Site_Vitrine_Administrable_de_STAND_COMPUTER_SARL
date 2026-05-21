<?php
include '../../config/db.php';

$id = $_GET['id'];

$pdo->prepare("DELETE FROM contacts WHERE id=?")->execute([$id]);

header("Location: manage.php");
exit();