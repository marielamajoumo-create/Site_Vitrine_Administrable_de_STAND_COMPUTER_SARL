<?php
include '../../config/db.php';

$id = $_GET['id'];

$pdo->prepare("DELETE FROM horaires WHERE id=?")->execute([$id]);

header("Location: manage.php");
exit();