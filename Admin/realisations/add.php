<?php
session_start();
require_once __DIR__ . '/../../config/db.php';
if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/connexion");
    exit();
}

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $uploadDir = __DIR__ . '/../uploads/realisations/';
    $uploadDir1 = __DIR__ . '/../uploads/realisations/videos/';
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
         /* =========================
       GALERIE DE VIDEOS
    ========================= */
    if (!empty($_FILES['videos']['name'][0])) {
        foreach ($_FILES['videos']['name'] as $key => $name) {
            if (!empty($name)) {

                $filename = time() . "_video_" . $key . "_" . basename($name);

                move_uploaded_file(
                    $_FILES['videos']['tmp_name'][$key],
                    $uploadDir1 . $filename
                );

                $videoStmt = $pdo->prepare("INSERT INTO realisation_videos(realisation_id, video_path)VALUES (?, ?)");
                $videoStmt->execute([$realisationId,$filename]);
            }
        }
    }


    header("Location: /StandComputer/gerer-les-realisations");
    exit();
}
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Ajouter une realisation </h1>
<br>
<br>

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
<br>
<br>

<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>

