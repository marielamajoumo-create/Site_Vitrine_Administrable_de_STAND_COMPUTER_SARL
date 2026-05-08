<?php
session_start();
include '../../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
/* 
              VERIFIER ID
*/
 if (!isset($_GET['id']) || empty ($_GET['id'])) {
    die ("ID du service manquant");
 }
 $id=intval ($_GET ['id']);


/* 
             RECUPERER SERVICE
             
*/

$stmt= $pdo-> prepare("SELECT * FROM services WHERE id=?");
$stmt->execute([$id]);
$service=$stmt->fetch(PDO::FETCH_ASSOC);
if (!$service) {
    die ("Service Introuvable");
}
if (isset($_POST['update'])) {

    $tittle = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];
    $image = $service['image']; // garder l’ancien par défaut
    $uploadDir = "../uploads/services/";

    // Vérifier si un nouveau thumbnail est uploadé
    if (!empty($_FILES['image']['name'])) {
        // Supprimer l’ancien fichier
        @unlink($uploadDir . $service['image']);

        // Générer un nouveau nom unique
        $image = uniqid() . "_" . basename($_FILES['image']['name']);

        // Déplacer le fichier
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    }

    $stmt = $pdo->prepare("
        UPDATE services
        SET title=?,
            category=?,
           description=?,
           image=?,
            icon=?
        WHERE id=?
    ");

 var_dump ([$tittle,$category, $description,  $image,$icon,$id]);
    try {
    $stmt->execute([$tittle,$category, $description,$image, $icon,  $id]);
} catch (PDOException $e) {
    die ("Erreur PDO : " .$e->getMessage());
}

header ("Location:manage.php? success=updated");
exit ();
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier ce service</h1>

<form method="POST" enctype="multipart/form-data">

    <input type="text" name="title"
           value="<?php echo $service['title']; ?>">
           
<input type="text" name="category"
           value="<?php echo $service['category']; ?>">
           
    <input type="text" name="description"
           value="<?php echo $service['description']; ?>">

    <input type="text" name="icon"
           value="<?php echo $service['icon']; ?>">
               <label>Image principale :</label>
    <img src="../uploads/services/<?php echo $service['image']; ?>" width="150"><br>
    <input type="file" name="image">

    <button type="submit" name="update">Mettre à jour</button>
</form>