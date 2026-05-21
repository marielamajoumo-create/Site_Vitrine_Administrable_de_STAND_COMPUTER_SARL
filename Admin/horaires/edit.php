<?php
include '../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM horaires WHERE id=?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {

    $pdo->prepare("
        UPDATE horaires
        SET jour=?, ouvertureFermeture=?
        WHERE id=?
    ")->execute([
        $_POST['jour'],
        $_POST['ouvertureFermeture'],
        $id
    ]);

    header("Location: manage.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier Horaire</h1>

<form method="POST">

    <input type="text" name="jour" value="<?= $data['jour'] ?>" required>
    <input type="text" name="ouvertureFermeture" value="<?= $data['ouvertureFermeture'] ?>" required>

    <button type="submit" name="update">Modifier</button>

</form>