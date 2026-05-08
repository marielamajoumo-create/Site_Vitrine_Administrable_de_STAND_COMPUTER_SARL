<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
$stmt->execute([$id]);

header("Location: manage.php");
exit();
?>

