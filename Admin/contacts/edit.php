<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id=?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {

    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $whatsapp = trim($_POST['whatsapp']);
    $localisation = trim($_POST['localisation']);
    $villeQuartier = trim($_POST['villeQuartier']);
    $pays = trim($_POST['pays']);

    $pdo->prepare("
        UPDATE contacts
        SET phone=?, email=?, whatsapp=?, localisation=?, villeQuartier=?, pays=?
        WHERE id=?
    ")->execute([
        $phone,
        $email,
        $whatsapp,
        $localisation,
        $villeQuartier,
        $pays,
        $id
    ]);

    header("Location: /StandComputer/gerer-les-contacts");
    exit();
}
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Modifier Contact</h1>
<br/>
<br/>

<form method="POST">

    <input type="text" name="phone" value="<?= $data['phone'] ?>" placeholder="telephone">
    <input type="email" name="email" value="<?= $data['email'] ?>" placeholder="email">
    <input type="text" name="whatsapp" value="<?= $data['whatsapp'] ?>" placeholder="whatsapp">
    <input type="text" name="localisation" value="<?= $data['localisation'] ?>" placeholder="localisation">
    <input type="text" name="villeQuartier" value="<?= $data['villeQuartier'] ?>" placeholder="ville/quartier">
    <input type="text" name="pays" value="<?= $data['pays'] ?>" placeholder="pays" >

    <button type="submit" name="update">Modifier</button>

</form>
<br/>
<br/>
<a href="/StandComputer/gerer-les-contacts" class="back">Retour au tableau de gestion 
            </a>
            <br/>
<br/>
<br>
            <br>
<a href="/StandComputer/tableau-de-bord" class="back">
                Retour au tableau de bord 
            </a>