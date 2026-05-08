<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $niveau = $_POST['niveau'];
    $intitule = $_POST['intitule'];
    $nombrePersonne = $_POST['nombrePersonne'];
    $natureDiplome = $_POST['natureDiplome'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $duration = $_POST['duration'];

    move_uploaded_file($tmp, "../uploads/formations/" . $image);

    $stmt = $pdo->prepare("
        INSERT INTO formations(niveau,title, intitule, description, image, duration, nombrePersonne, natureDiplome)
        VALUES (?, ?, ?,?,?,?,?,?)
    ");

    $stmt->execute([ $niveau, $title,$intitule, $description, $image, $duration, $nombrePersonne, $natureDiplome]);

    header("Location: ../formations/manage.php");
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Ajouter une Formation</h1>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Titre de la formation" required>
    <input type="text" name="niveau" placeholder="niveau de la formation" required>
    <input type="text" name="intitule" placeholder="intitule de la formation" required>

    <textarea name="description" placeholder="Description" required></textarea>

    <input type="file" name="image" required>
     <input type="text" name="duration" placeholder="duree de la formation" required>
     <input type="text" name="nombrePersonne" placeholder="nombre de personnes  pour la formation" required>
     <input type="text" name="natureDiplome" placeholder="nature du diplome de fin  de la formation" required>
    <button type="submit" name="submit">Ajouter</button>

</form>
