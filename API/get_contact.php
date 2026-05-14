
<?php
header('Content-Type: application/json');
include '../config/db.php'; // connexion à ta BDD

$contacts= $pdo->query ("SELECT id, phone, email, localisation, whatsapp, villeQuartier, pays FROM contacts ORDER BY id ASC LIMIT 1 ")->fetch(PDO::FETCH_ASSOC);
echo json_encode($contacts);
?>



