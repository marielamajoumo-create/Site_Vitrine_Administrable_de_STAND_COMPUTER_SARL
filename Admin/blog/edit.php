<?php
require_once '../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $categorie_id = $_POST['categorie_id'];
  $auteur = $_POST['auteur'];
  $featured = isset($_POST['featured']) ? 1 : 0;

  // image (optionnelle)
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/articles/".$image);
  } else {
    $image = $article['image'];
  }

  $stmt = $pdo->prepare("
    UPDATE articles
    SET titre=?, contenu=?, image=?, categorie_id=?, auteur=?, featured=?
    WHERE id=?
  ");

  $stmt->execute([$titre,$contenu,$image,$categorie_id,$auteur,$featured,$id]);

  header("Location: manage.php");
}
?>


<link rel="stylesheet" href="../../assets/css/admin.css">

<h1>Modifier article</h1>

<form method="POST" enctype="multipart/form-data">

  <input type="text" name="titre" value="<?= htmlspecialchars($article['titre']) ?>"><br><br>

  <textarea name="contenu"><?= htmlspecialchars($article['contenu']) ?></textarea><br><br>

  <select name="categorie_id">
    <?php foreach($categories as $c): ?>
      <option value="<?= $c['id'] ?>" <?= $article['categorie_id']==$c['id']?'selected':'' ?>>
        <?= $c['nom'] ?>
      </option>
    <?php endforeach; ?>
  </select><br><br>

  <input type="text" name="auteur" value="<?= $article['auteur'] ?>"><br><br>

  <input type="file" name="image"><br>
  <img src="../uploads/articles/<?= $article['image'] ?>" width="100"><br><br>

  <label>
    <input type="checkbox" name="featured" <?= $article['featured'] ? 'checked' : '' ?>>
    Article à la une
  </label><br><br>

  <button type="submit" name="update">Mettre à jour</button>
</form>