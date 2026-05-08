<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $uploadDir="../uploads/realisations/";
    if (!is_dir ($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    /* THUMBNAIL*/
    $thumbnail=time(). "_thumb_" . basename($_FILES['thumbnail']['name']);
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir.$thumbnail);
   

    $stmt = $pdo->prepare("
        INSERT INTO realisations(title, category, description, thumbnail)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([$title, $category, $description, $thumbnail]);
    $realisationId=$pdo->lastInsertId();
    /* GALERIE MULTIPLE*/
    foreach ($_FILES['images']['name'] as $key=> $name) {
        if (!empty ($name)) {
            $filename=time() . "_" . basename ($name);
            move_uploaded_file (
                $_FILES ['images']['tmp_name'] [$key],
                $uploadDir . $filename
            );
            $imgStmt = $pdo->prepare("INSERT INTO realisation_images (realisation_id, image_path) VALUES (?, ?)");
            $imgStmt -> execute ([$realisationId,$filename]);
        }
    }

    header("Location: manage.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Ajouter une realisation </h1>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Titre de la realisation" required>
    <input type="text" name="category" placeholder="categorie de la realisation" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <label> Image Principale: </label>
    <input type="file" name="thumbnail" required > 
    <label> Galerie : </label>
    <input type="file" name="images[]" multiple > 
   
    <button type="submit" name="submit">Ajouter</button>

</form>
