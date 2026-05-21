<?php
require_once 'config/db.php';

/*
|--------------------------------------------------------------------------
| Récupération de l'ID de l'article
|--------------------------------------------------------------------------
*/
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(404);
    die('Article introuvable.');
}

/*
|--------------------------------------------------------------------------
| Article principal
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT a.*, c.nom AS categorie
    FROM articles a
    LEFT JOIN categories c ON a.categorie_id = c.id
    WHERE a.id = ?
");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    http_response_code(404);
    die('Article introuvable.');
}

/*
|--------------------------------------------------------------------------
| Articles récents (sidebar)
|--------------------------------------------------------------------------
*/
$recent = $pdo->query("
    SELECT id, titre, image, date_pub
    FROM articles
    ORDER BY date_pub DESC
    LIMIT 5
")->fetchAll();

/*
|--------------------------------------------------------------------------
| Articles similaires (même catégorie)
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT id, titre, image, date_pub
    FROM articles
    WHERE categorie_id = ?
      AND id != ?
    ORDER BY date_pub DESC
    LIMIT 4
");
$stmt->execute([$article['categorie_id'], $article['id']]);
$related = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/
$pageTitle = $article['titre'] . ' | Blog Stand Computer';
$metaDescription = mb_substr(
    trim(strip_tags($article['contenu'])),
    0,
    160,
    'UTF-8'
);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>" />

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

  <link rel="stylesheet" href="assets/css/shared.css" />
  <link rel="stylesheet" href="assets/css/article.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<div id="nav-placeholder"></div>

<!-- HERO : uniquement breadcrumb -->
<section class="page-hero article-hero">
  <div class="container page-hero-inner">

    <div class="breadcrumb">
      <a href="index.php">Accueil</a>
      <span class="sep">›</span>
      <a href="blog.php">Blog</a>
      <span class="sep">›</span>
      <span class="current">
        <?= htmlspecialchars($article['titre']) ?>
      </span>
    </div>
      <h1><?= htmlspecialchars($article['titre']) ?></h1>
<p>
  Découvrez notre article sur 
  <span class="accent"><?= htmlspecialchars($article['categorie']) ?></span>, 
  publié le <?= date('d M Y', strtotime($article['date_pub'])) ?>.
</p>
  </div>
  </section>

<!-- CONTENU -->
<section class="article-section">
  <div class="container article-layout">

    <!-- ARTICLE PRINCIPAL -->
    <article class="article-content-card">

      <?php if (!empty($article['image'])): ?>
        <img
          src="admin/uploads/articles/<?= htmlspecialchars($article['image']) ?>"
          alt="<?= htmlspecialchars($article['titre']) ?>"
          class="article-cover"
        />
      <?php endif; ?>

      <div class="article-content">

        <!-- Informations de l'article -->
        <div class="article-info">

          <?php if (!empty($article['categorie'])): ?>
            <span class="article-category">
              <?= htmlspecialchars($article['categorie']) ?>
            </span>
          <?php endif; ?>

          <h1 class="article-title">
            <?= htmlspecialchars($article['titre']) ?>
          </h1>

          <div class="article-meta-content">

            <span>
              <span class="material-icons-round">calendar_today</span>
              <?= date('d M Y', strtotime($article['date_pub'])) ?>
            </span>

            <?php if (!empty($article['auteur'])): ?>
              <span>
                <span class="material-icons-round">person</span>
                <?= htmlspecialchars($article['auteur']) ?>
              </span>
            <?php endif; ?>

          </div>
        </div>

        <!-- Contenu complet -->
        <?= nl2br($article['contenu']) ?>

      </div>
    </article>

    <!-- SIDEBAR -->
    <aside class="article-sidebar">

      <div class="sidebar-widget">
        <h3>Articles récents</h3>

        <?php foreach ($recent as $r): ?>
          <a href="article.php?id=<?= (int) $r['id'] ?>" class="recent-post">

            <?php if (!empty($r['image'])): ?>
              <img
                src="admin/uploads/articles/<?= htmlspecialchars($r['image']) ?>"
                alt="<?= htmlspecialchars($r['titre']) ?>"
              />
            <?php endif; ?>

            <div>
              <h4><?= htmlspecialchars($r['titre']) ?></h4>
              <span><?= date('d M Y', strtotime($r['date_pub'])) ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

    </aside>

  </div>
</section>

<!-- ARTICLES SIMILAIRES -->
<?php if (!empty($related)): ?>
<section class="related-section">
  <div class="container">
    <h2>Articles similaires</h2>

    <div class="related-grid">
      <?php foreach ($related as $item): ?>
        <a
          href="article.php?id=<?= (int) $item['id'] ?>"
          class="related-card"
        >
          <?php if (!empty($item['image'])): ?>
            <img
              src="admin/uploads/articles/<?= htmlspecialchars($item['image']) ?>"
              alt="<?= htmlspecialchars($item['titre']) ?>"
            />
          <?php endif; ?>

          <div class="related-body">
            <h3><?= htmlspecialchars($item['titre']) ?></h3>
            <span>
              <?= date('d M Y', strtotime($item['date_pub'])) ?>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<div id="footer-placeholder"></div>
<div id="fab-placeholder"></div>

<script src="components.js"></script>
<script>
  initComponents('blog');
</script>

</body>
</html>