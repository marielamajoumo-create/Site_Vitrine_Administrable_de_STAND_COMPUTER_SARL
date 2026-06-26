<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/connexion");
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
    $uploadDir = __DIR__ . '/../uploads/formations/';

    move_uploaded_file($tmp, $uploadDir. $image);

    $stmt = $pdo->prepare("
        INSERT INTO formations(niveau,title, intitule, description, image, duration, nombrePersonne, natureDiplome)
        VALUES (?, ?, ?,?,?,?,?,?)
    ");

    $stmt->execute([ $niveau, $title,$intitule, $description, $image, $duration, $nombrePersonne, $natureDiplome]);

    header("Location: /StandComputer/gerer-les-formations");
}
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Ajouter une Formation</h1>
<br/>
<br/>

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
<br/>
<br/>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
