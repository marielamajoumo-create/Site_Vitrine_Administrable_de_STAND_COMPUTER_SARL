<?php
include 'config/db.php';
if (!isset ($_GET['id'])) {
    die("service non trouve");
}
$id=$_GET['id'];
$stmt=$pdo->prepare ("SELECT * FROM services WHERE id=?");
$stmt-> execute([$id]);
$service= $stmt-> fetch(PDO::FETCH_ASSOC);
if (!$service) {
    die ("Service Introuvable");
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Réalisations – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />