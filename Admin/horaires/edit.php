<?php
require_once __DIR__ . '/../../config/db.php';

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

    header("Location: /StandComputer/gerer-les-horaires");
    exit();
}
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Modifier Horaire</h1>
<br>
<br>

<form method="POST">

    <input type="text" name="jour" value="<?= $data['jour'] ?>" required>
    <input type="text" name="ouvertureFermeture" value="<?= $data['ouvertureFermeture'] ?>" required>

    <button type="submit" name="update">Modifier</button>

</form>
<br>
<br>
<a href="/StandComputer/gerer-les-horaires" class="back">Retour au tableau de gestion 
            </a>
            <br/>
<br/>
<br>
            <br>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>