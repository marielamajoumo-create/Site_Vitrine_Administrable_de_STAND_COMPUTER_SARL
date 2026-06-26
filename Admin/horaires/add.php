<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

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

    header("Location: /StandComputer/gerer-les-horaires");
    exit();
}
?>
<link rel="stylesheet" href="/StandComputer/style-admin">


<h1>Ajouter Horaire</h1>
<br>
<br>

<form method="POST">

    <input type="text" name="jour" placeholder="Jour (ex: Lundi - Vendredi)" required>
    <input type="text" name="ouvertureFermeture" placeholder="8h30 - 16h00" required>

    <button type="submit" name="submit">Ajouter</button>

</form>
<br>
<br>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
