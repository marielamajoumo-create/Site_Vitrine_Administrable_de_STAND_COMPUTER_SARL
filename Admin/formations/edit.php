

<?php
session_start();
include '../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM formations WHERE id=?");
$stmt->execute([$id]);
$formation = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $niveau = $_POST['niveau']; 
    $title = $_POST['title']; 
    $intitule = $_POST['intitule'];
    $description = $_POST['description'];
    
    $duration = $_POST['duration'];
    $nombrePersonne = $_POST['nombrePersonne'];
    $natureDiplome = $_POST['natureDiplome'];


    $image = $formation['image']; // garder l’ancien par défaut
    $uploadDir = "../uploads/formations/";

    // Vérifier si un nouveau thumbnail est uploadé
    if (!empty($_FILES['image']['name'])) {
        // Supprimer l’ancien fichier
        @unlink($uploadDir . $formation['image']);

        // Générer un nouveau nom unique
        $image = uniqid() . "_" . basename($_FILES['image']['name']);

        // Déplacer le fichier
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    }
    $duration = $_POST['duration'];
    $nombrePersonne = $_POST['nombrePersonne'];
    $natureDiplome = $_POST['natureDiplome'];

    // Mise à jour en base
    $pdo->prepare("
        UPDATE formations
        SET niveau=?,
            title=?,
            intitule=?,
            description=?,
            image=?,
            duration=?,
            nombrePersonne=?,
            natureDiplome=?
            
            
        WHERE id=?
    ")->execute([$niveau,$title,$intitule, $description, $image,$duration,$nombrePersonne,$natureDiplome, $id]);

    header("Location: manage.php");
    exit();
}
?>

<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier cette formation</h1>

<form method="POST" enctype="multipart/form-data">
     <input type="text" name="niveau"
           value="<?php echo $formation['niveau']; ?>">


    <input type="text" name="title"
           value="<?php echo $formation['title']; ?>">
    <input type="text" name="intitule"
           value="<?php echo $formation['intitule']; ?>">


    <input type="text" name="description"
           value="<?php echo $formation['description']; ?>">

    
          <img src="../uploads/formations/<?php echo $formation['image']; ?>" width="150"><br>
          <input type="file" name="image">
            <input type="text" name="duration"
           value="<?php echo $formation['duration']; ?>">
    <input type="text" name="nombrePersonne"
           value="<?php echo $formation['nombrePersonne']; ?>">
    <input type="text" name="natureDiplome"
           value="<?php echo $formation['natureDiplome']; ?>">



    <button type="submit" name="update">Mettre à jour</button>
</form>

