<?php
session_start();
include '../../config/db.php';

$id = $_GET['id'];

if (isset($_POST['upload'])) {

    $uploadDir = "../uploads/realisations/";

    foreach ($_FILES['images']['name'] as $key => $name) {

        if (!empty($name)) {

            $fileName = time() . "_" . basename($name);

            move_uploaded_file(
                $_FILES['images']['tmp_name'][$key],
                $uploadDir . $fileName
            );

            $stmt = $pdo->prepare("
                INSERT INTO realisation_images(realisation_id, image_path)
                VALUES (?, ?)
            ");
              $stmt->execute([$id, $fileName]);
        }
    }
}

/* IMAGES EXISTANTES */
$images = $pdo->prepare("
    SELECT * FROM realisation_images
    WHERE realisation_id=?
");
$images->execute([$id]);
$gallery = $images->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Ajouter / Gérer les Images</h1>

<form method="POST" enctype="multipart/form-data">

    <input type="file" name="images[]" multiple>

    <button type="submit" name="upload">Uploader</button>

</form>

<?php foreach($gallery as $img): ?>
    <div  class="gallery-item" style="display:inline-block; margin:10px;">
        <img src="../uploads/realisations/<?php echo $img['image_path']; ?>" width="150">
        <a  href="delete.php?image_id=<?php echo $img['id']; ?>&realisation_id=<?php echo $id; ?>" class="btn btn-delete">
            Supprimer
        </a>
    </div>
<?php endforeach; ?>