<?php
 require_once __DIR__ . '/../../config/db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $categorie_id = $_POST['categorie_id'];
  $auteur = $_POST['auteur'];
  $featured = isset($_POST['featured']) ? 1 : 0;
  $uploadDir = __DIR__ . '/../uploads/articles/';

  // IMAGE UPLOAD
  $image = $_FILES['image']['name'];
  $tmp = $_FILES['image']['tmp_name'];
  move_uploaded_file($tmp, $uploadDir.$image);

  $stmt = $pdo->prepare("
    INSERT INTO articles (titre, contenu, image, categorie_id, auteur, featured)
    VALUES (?, ?, ?, ?, ?, ?)
  ");

  $stmt->execute([$titre, $contenu, $image, $categorie_id, $auteur, $featured]);
  $articleId = $pdo->lastInsertId();

if (!empty($_POST['tags'])) {

    $tags = explode(',', $_POST['tags']);

    foreach ($tags as $tag) {

        $tag = trim($tag);

        if (empty($tag)) {
            continue;
        }

        $slug = strtolower($tag);

        $slug = str_replace(' ', '-', $slug);

        $check = $pdo->prepare("
            SELECT id
            FROM tags
            WHERE nom = ?
        ");

        $check->execute([$tag]);

        $tagId = $check->fetchColumn();

        if (!$tagId) {

            $insertTag = $pdo->prepare("
                INSERT INTO tags(nom, slug)
                VALUES (?, ?)
            ");

            $insertTag->execute([
                $tag,
                $slug
            ]);

            $tagId = $pdo->lastInsertId();
        }

        $link = $pdo->prepare("
            INSERT INTO article_tags(article_id, tag_id)
            VALUES (?, ?)
        ");

        $link->execute([
            $articleId,
            $tagId
        ]);
    }
}

  header("Location: /StandComputer/gerer-les-articles");
}
?>


<link rel="stylesheet" href="/StandComputer/style-admin">
<h1>Ajouter un article</h1>
<br/>
<br/>

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

  <label>Tags (séparés par des virgules)</label><br>
<input
    type="text"
    name="tags"
    placeholder="PHP, JavaScript, Cybersécurité"
><br><br>

  <button type="submit" name="submit">Publier</button>
</form>
<br/>
<br/>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>

