<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/connexion");
    exit();
}

if (isset($_POST['submit'])) {

    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $whatsapp = trim($_POST['whatsapp']);
    $localisation = trim($_POST['localisation']);
    $villeQuartier = trim($_POST['villeQuartier']);
    $pays = trim($_POST['pays']);

    $stmt = $pdo->prepare("
        INSERT INTO contacts(phone, email, whatsapp, localisation, villeQuartier, pays)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $phone,
        $email,
        $whatsapp,
        $localisation,
        $villeQuartier,
        $pays
    ]);

    header("Location: /StandComputer/gerer-les-contacts");
    exit();
}
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Ajouter Contact</h1>
<br/>
<br/>

<form method="POST">

    <input type="text" name="phone" placeholder="Téléphone" >
    <input type="email" name="email" placeholder="Email" >
    <input type="text" name="whatsapp" placeholder="WhatsApp" >
    <input type="text" name="localisation" placeholder="Localisation" >
    <input type="text" name="villeQuartier" placeholder="Ville / Quartier" >
    <input type="text" name="pays" placeholder="Pays" >

    <button type="submit" name="submit">Ajouter</button>

</form>
<br/>
<br/>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
