<?php
session_start();
include '../../config/db.php';

/* SUPPRIMER IMAGE UNIQUE */
if (isset($_GET['image_id'])) {

    $imageId = $_GET['image_id'];
    $realisationId = $_GET['realisation_id'];

    $img = $pdo->prepare("
        SELECT image_path FROM realisation_images WHERE id=?
    ");
    $img->execute([$imageId]);
    $file = $img->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        @unlink("../uploads/realisations/" . $file['image_path']);
    }

    $stmt = $pdo->prepare("
        DELETE FROM realisation_images WHERE id=?
    ");
    $stmt->execute([$imageId]);
    header("Location: upload_images.php?id=" . $realisationId);
    exit();
}

/* SUPPRIMER RÉALISATION COMPLÈTE */
$id = $_GET['id'];

/* THUMBNAIL */
$real = $pdo->prepare("
    SELECT thumbnail FROM realisations WHERE id=?
");
$real->execute([$id]);
$data = $real->fetch(PDO::FETCH_ASSOC);

if ($data) {
    @unlink("../uploads/realisations/" . $data['thumbnail']);
}

/* GALERIE */
$images = $pdo->prepare("
    SELECT image_path FROM realisation_images WHERE realisation_id=?
");
$images->execute([$id]);

foreach ($images as $img) {
    @unlink("../uploads/realisations/" . $img['image_path']);
}
/* DELETE DB */
$pdo->prepare("DELETE FROM realisations WHERE id=?")->execute([$id]);

header("Location: manage.php");
exit();
?>