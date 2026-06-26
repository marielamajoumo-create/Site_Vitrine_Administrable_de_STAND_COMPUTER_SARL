<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM services WHERE id=?");
$stmt->execute([$id]);

header("Location: /StandComputer/gerer-les-services");
exit();
?>

