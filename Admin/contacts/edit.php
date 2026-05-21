<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
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

    header("Location: manage.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier Contact</h1>

<form method="POST">

    <input type="text" name="phone" value="<?= $data['phone'] ?>" placeholder="telephone">
    <input type="email" name="email" value="<?= $data['email'] ?>" placeholder="email">
    <input type="text" name="whatsapp" value="<?= $data['whatsapp'] ?>" placeholder="whatsapp">
    <input type="text" name="localisation" value="<?= $data['localisation'] ?>" placeholder="localisation">
    <input type="text" name="villeQuartier" value="<?= $data['villeQuartier'] ?>" placeholder="ville/quartier">
    <input type="text" name="pays" value="<?= $data['pays'] ?>" placeholder="pays" >

    <button type="submit" name="update">Modifier</button>

</form>