<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['update'])) {

    $projects = $_POST['projects_completed'];
    $clients = $_POST['clients_satisfied'];
    $years = $_POST['years_experience'];
    $experts = $_POST['experts_count'];

    $stmt = $pdo->prepare("
        UPDATE statistiques
        SET projects_completed=?,
            clients_satisfied=?,
            years_experience=?,
            experts_count=?
        WHERE id=1
    ");

    $stmt->execute([$projects, $clients, $years, $experts]);
}

$stats = $pdo->query("SELECT * FROM statistiques WHERE id=1")->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier les Statistiques</h1>

<form method="POST">

    <input type="number" name="projects_completed"
           value="<?php echo $stats['projects_completed']; ?>">

    <input type="number" name="clients_satisfied"
           value="<?php echo $stats['clients_satisfied']; ?>">

    <input type="number" name="years_experience"
           value="<?php echo $stats['years_experience']; ?>">

    <input type="number" name="experts_count"
           value="<?php echo $stats['experts_count']; ?>">

    <button type="submit" name="update">Mettre à jour</button>

</form>

