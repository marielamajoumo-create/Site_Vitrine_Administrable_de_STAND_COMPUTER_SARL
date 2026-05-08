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
    //$slug= slugify ($title);
    $description = $_POST['description'];
    $icon= $_POST['icon'];
    $image=$_POST['image'];
    $uploadDir="../uploads/services/";
    if (!is_dir ($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    /* THUMBNAIL*/
    $image=time(). "_" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$image);
    

   

    $stmt = $pdo->prepare("
        INSERT INTO services(title, description, icon,category,image)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([$title, $description, $icon, $category,$image]);

    header("Location: manage.php");
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Ajouter un Service</h1>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title" placeholder="Titre du service" required>
    <input type="text" name="category" placeholder="categorie du service" required>
    <label> Image Principale: </label>
    <input type="file" name="image" required > 

    <textarea name="description" placeholder="Description" required></textarea>
    <input type="text" name="icon" placeholder="icone du service" required>   
   
    <button type="submit" name="submit">Ajouter</button>

</form>
