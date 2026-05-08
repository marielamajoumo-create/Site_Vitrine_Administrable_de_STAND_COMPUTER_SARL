<?php
session_start();
include '../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM realisations WHERE id=?");
$stmt->execute([$id]);
$real = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $thumbnail = $real['thumbnail']; // garder l’ancien par défaut
    $uploadDir = "../uploads/realisations/";

    // Vérifier si un nouveau thumbnail est uploadé
    if (!empty($_FILES['thumbnail']['name'])) {
        // Supprimer l’ancien fichier
        @unlink($uploadDir . $real['thumbnail']);

        // Générer un nouveau nom unique
        $thumbnail = uniqid() . "_thumb_" . basename($_FILES['thumbnail']['name']);

        // Déplacer le fichier
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadDir . $thumbnail);
    }

    // Mise à jour en base
    $pdo->prepare("
        UPDATE realisations
        SET title=?, category=?, description=?, thumbnail=?
        WHERE id=?
    ")->execute([$title, $category, $description, $thumbnail, $id]);

    header("Location: manage.php");
    exit();
}
?>
<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier cette  realisation</h1>


<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title"
           value="<?php echo htmlspecialchars($real['title']); ?>">

    <input type="text" name="category"
           value="<?php echo htmlspecialchars($real['category']); ?>">

    <textarea name="description"><?php echo htmlspecialchars($real['description']); ?></textarea>

    <label>Image principale :</label>
    <img src="../uploads/realisations/<?php echo $real['thumbnail']; ?>" width="150"><br>
    <input type="file" name="thumbnail">

    <button type="submit" name="update">Mettre à jour</button>
</form>
