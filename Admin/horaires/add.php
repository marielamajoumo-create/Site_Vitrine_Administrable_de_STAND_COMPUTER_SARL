<?php
session_start();
include '../../config/db.php';

if (isset($_POST['submit'])) {

    $jour = trim($_POST['jour']);
    $ouvertureFermeture = trim($_POST['ouvertureFermeture']);

    $stmt = $pdo->prepare("
        INSERT INTO horaires(jour, ouvertureFermeture)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $jour,
        $ouvertureFermeture
    ]);

    header("Location: manage.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Ajouter Horaire</h1>

<form method="POST">

    <input type="text" name="jour" placeholder="Jour (ex: Lundi - Vendredi)" required>
    <input type="text" name="ouvertureFermeture" placeholder="8h30 - 16h00" required>

    <button type="submit" name="submit">Ajouter</button>

</form>