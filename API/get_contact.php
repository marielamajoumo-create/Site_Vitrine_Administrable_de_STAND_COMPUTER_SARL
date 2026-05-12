<?php
header('Content-Type: application/json');
include '../config/db.php'; // connexion à ta BDD

$contacts= $pdo->query("SELECT id, phone, email, adresse, villeQuartier, pays FROM contacts ORDER BY id ASC LIMIT 1 ")->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($contacts);
?>



