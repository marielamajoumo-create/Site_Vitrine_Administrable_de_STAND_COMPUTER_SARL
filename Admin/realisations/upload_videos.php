
<?php
session_start();
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("Réalisation invalide.");
}

if (isset($_POST['upload'])) {

    $uploadDir = __DIR__ . '/../uploads/realisations/videos/';
    // Créer le dossier s'il n'existe pas
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Upload des vidéos
    if (!empty($_FILES['videos']['name'][0])) {
        foreach ($_FILES['videos']['name'] as $key => $name) {

            if (!empty($name)) {

                $fileName = time() . "_video_" . $key . "_" . basename($name);

                move_uploaded_file(
                    $_FILES['videos']['tmp_name'][$key],
                    $uploadDir . $fileName
                );

                $stmt = $pdo->prepare("
                    INSERT INTO realisation_videos (realisation_id, video_path)
                    VALUES (?, ?)
                ");

                $stmt->execute([$id, $fileName]);
            }
        }
    }

    // Recharger la page après upload
    header("Location: /StandComputer/modifier-les-videos-de-cette-realisation?id=" . $id);
    exit();
}

/* =========================
   VIDÉOS EXISTANTES
========================= */
$videos = $pdo->prepare("
    SELECT * FROM realisation_videos
    WHERE realisation_id = ?
    ORDER BY id DESC
");
$videos->execute([$id]);
$gallery = $videos->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Ajouter / Gérer les Vidéos</h1>

<form method="POST" enctype="multipart/form-data">

    <input
        type="file"
        name="videos[]"
        accept="video/*"
        multiple
    >

    <button type="submit" name="upload">
        Uploader
    </button>

</form>


<?php if (!empty($gallery)): ?>
    <?php foreach ($gallery as $video): ?>
        <div class="gallery-item" style="display:inline-block; margin:10px; vertical-align:top;">

            <video width="220" controls>
                <source
                    src="/StandComputer/admin/uploads/realisations/videos/<?php echo htmlspecialchars($video['video_path']); ?>"
                    type="video/mp4"
                >
                Votre navigateur ne supporte pas la lecture vidéo.
            </video>

            <br><br>

            

            <a
                href="/StandComputer/supprimer-realisation?video_id=<?php echo $video['id']; ?>&realisation_id=<?php echo $id; ?>"
                class="btn btn-delete"
                onclick="return confirm('Supprimer cette vidéo ?')"
            >
                Supprimer
            </a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune vidéo disponible pour cette réalisation.</p>
    
<?php endif; ?>
<br/>
<br/>
<br/>
<br/>
<br/>
<a href="/StandComputer/gerer-les-realisations" class="back">Retour au tableau de gestion 
            </a>
            <br/>
            <br>
            <br>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>

