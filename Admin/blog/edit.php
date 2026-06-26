<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();
$tagStmt = $pdo->prepare("
    SELECT t.nom
    FROM tags t
    INNER JOIN article_tags at
        ON at.tag_id = t.id
    WHERE at.article_id = ?
");

$tagStmt->execute([$id]);

$articleTags = $tagStmt->fetchAll(PDO::FETCH_COLUMN);

$tagsString = implode(', ', $articleTags);

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $titre = $_POST['titre'];
  $contenu = $_POST['contenu'];
  $categorie_id = $_POST['categorie_id'];
  $auteur = $_POST['auteur'];
  $featured = isset($_POST['featured']) ? 1 : 0;
  $uploadDir = __DIR__ . '/../uploads/articles/';

  // image (optionnelle)
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$image);
  } else {
    $image = $article['image'];
  }

  $stmt = $pdo->prepare("
    UPDATE articles
    SET titre=?, contenu=?, image=?, categorie_id=?, auteur=?, featured=?
    WHERE id=?
  ");

  $stmt->execute([$titre,$contenu,$image,$categorie_id,$auteur,$featured,$id]);
  $pdo->prepare("
    DELETE FROM article_tags
    WHERE article_id = ?
")->execute([$id]);
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

        $pdo->prepare("
            INSERT INTO article_tags(article_id, tag_id)
            VALUES (?, ?)
        ")->execute([
            $id,
            $tagId
        ]);
    }
}

  header("Location: /StandComputer/gerer-les-articles");
}
?>


<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Modifier article</h1>
<br/>
<br/>

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
  <label>Tags (séparés par des virgules)</label><br>

<input
    type="text"
    name="tags"
    value="<?= htmlspecialchars($tagsString) ?>"
    placeholder="PHP, MySQL, Sécurité"
><br><br>

  <input type="file" name="image"><br>
  <img src="/StandComputer/admin/uploads/articles/<?= $article['image'] ?>" width="100"><br><br>

  <label>
    <input type="checkbox" name="featured" <?= $article['featured'] ? 'checked' : '' ?>>
    Article à la une
  </label><br><br>

  <button type="submit" name="update">Mettre à jour</button>
</form>
<br/>
<br/>

<a href="/StandComputer/gerer-les-articles" class="back">Retour au tableau de gestion 
            </a>
            <br/>
            <br>
            <br>

<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>