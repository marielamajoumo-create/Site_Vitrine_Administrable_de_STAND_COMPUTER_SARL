<?php
session_start();
require_once __DIR__ . '/../../config/db.php';


/* =========================
   SUPPRIMER IMAGE UNIQUE
========================= */
if (isset($_GET['image_id'])) {

    $imageId = (int) $_GET['image_id'];
    $realisationId = (int) $_GET['realisation_id'];

    $img = $pdo->prepare("
        SELECT image_path 
        FROM realisation_images 
        WHERE id = ?
    ");
    $img->execute([$imageId]);

    $file = $img->fetch(PDO::FETCH_ASSOC);

    if ($file) {

        $path = __DIR__ . '/../uploads/realisations/' . $file['image_path'];
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $stmt = $pdo->prepare("
        DELETE FROM realisation_images 
        WHERE id = ?
    ");
    $stmt->execute([$imageId]);

    header("Location: /StandComputer/modifier-les-images-de-cette-realisation?id=" . $realisationId);
    
    exit();
}



/* =========================
   SUPPRIMER VIDÉO UNIQUE
========================= */
if (isset($_GET['video_id'])) {

    $videoId = (int) $_GET['video_id'];
    $realisationId = (int) $_GET['realisation_id'];

    $video = $pdo->prepare("
        SELECT video_path 
        FROM realisation_videos 
        WHERE id = ?
    ");
    $video->execute([$videoId]);

    $file = $video->fetch(PDO::FETCH_ASSOC);

    if ($file) {

        $path1 = __DIR__ . '/../uploads/realisations/videos/' . $file['video_path'];

        if (file_exists($path1)) {
            unlink($path1);
        }
    }

    $stmt = $pdo->prepare("
        DELETE FROM realisation_videos 
        WHERE id = ?
    ");
    $stmt->execute([$videoId]);

    header("Location: /StandComputer/modifier-les-videos-de-cette-realisation?id=" . $realisationId);
    exit();
}



/* =========================
   SUPPRIMER RÉALISATION
========================= */

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID invalide.");
}


/* THUMBNAIL */
$real = $pdo->prepare("
    SELECT thumbnail 
    FROM realisations 
    WHERE id = ?
");
$real->execute([$id]);

$data = $real->fetch(PDO::FETCH_ASSOC);

if ($data && !empty($data['thumbnail'])) {

    $thumbPath = __DIR__ . '/../uploads/realisations/'  . $data['thumbnail'];

    if (file_exists($thumbPath)) {
        unlink($thumbPath);
    }
}


/* GALERIE IMAGES */
$images = $pdo->prepare("
    SELECT image_path 
    FROM realisation_images 
    WHERE realisation_id = ?
");
$images->execute([$id]);

foreach ($images as $img) {

    $imgPath = __DIR__ . '/../uploads/realisations/videos/' . $img['image_path'];

    if (file_exists($imgPath)) {
        unlink($imgPath);
    }
}


/* GALERIE VIDÉOS */
$videos = $pdo->prepare("
    SELECT video_path 
    FROM realisation_videos 
    WHERE realisation_id = ?
");
$videos->execute([$id]);

foreach ($videos as $video) {

    $videoPath =  __DIR__ . '/../uploads/realisations/videos/'  . $video['video_path'];

    if (file_exists($videoPath)) {
        unlink($videoPath);
    }
}


/* DELETE DB */
$pdo->prepare("DELETE FROM realisations WHERE id=?")->execute([$id]);

header("Location: /StandComputer/gerer-les-realisations");
exit();
?>