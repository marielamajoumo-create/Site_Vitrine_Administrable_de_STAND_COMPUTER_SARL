<?php
require_once '../../config/db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $categorie_id = $_POST['categorie_id'];
  $auteur = $_POST['auteur'];
  $featured = isset($_POST['featured']) ? 1 : 0;

  // IMAGE UPLOAD
  $image = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  move_uploaded_file($tmp, "../uploads/articles/".$image);

  $stmt = $pdo->prepare("
    INSERT INTO articles (titre, contenu, image, categorie_id, auteur, featured)
    VALUES (?, ?, ?, ?, ?, ?)
  ");

  $stmt->execute([$titre, $contenu, $image, $categorie_id, $auteur, $featured]);

  header("Location: manage.php");
}
?>


<link rel="stylesheet" href="../../assets/css/admin.css">
<h1>Ajouter un article</h1>

<form method="POST" enctype="multipart/form-data">

  <input type="text" name="titre" placeholder="Titre" required><br><br>

  <textarea name="contenu" placeholder="Contenu" required></textarea><br><br>

  <select name="categorie_id" required>
    <?php foreach($categories as $c): ?>
      <option value="<?= $c['id'] ?>"><?= $c['nom'] ?></option>
    <?php endforeach; ?>
  </select><br><br>

  <input type="text" name="auteur" placeholder="Auteur"><br><br>

  <input type="file" name="image" required><br><br>

  <label>
    <input type="checkbox" name="featured"> Article à la une
  </label><br><br>

  <button type="submit" name="submit">Publier</button>
</form>