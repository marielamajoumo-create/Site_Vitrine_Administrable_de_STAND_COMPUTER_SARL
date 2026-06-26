<?php
require_once 'config/db.php';

/*
|--------------------------------------------------------------------------
| RÉCUP SLUG TAG
|--------------------------------------------------------------------------
*/
$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$slug = $url[2] ?? null;

if (!$slug) {
    http_response_code(404);
    die("Tag introuvable");
}

/*
|--------------------------------------------------------------------------
| TAG INFO
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM tags
    WHERE slug = ?
");
$stmt->execute([$slug]);
$tag = $stmt->fetch();

if (!$tag) {
    http_response_code(404);
    die("Tag introuvable");
}

/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/
$articlesParPage = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) $page = 1;

$depart = ($page - 1) * $articlesParPage;

/*
|--------------------------------------------------------------------------
| COUNT ARTICLES DU TAG
|--------------------------------------------------------------------------
*/
$countStmt = $pdo->prepare("
    SELECT COUNT(*) as total
    FROM articles a
    INNER JOIN article_tags at ON at.article_id = a.id
    INNER JOIN tags t ON t.id = at.tag_id
    WHERE t.slug = ?
");

$countStmt->execute([$slug]);
$total = $countStmt->fetch()['total'];

$totalPages = ceil($total / $articlesParPage);

/*
|--------------------------------------------------------------------------
| ARTICLES DU TAG
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT a.*, c.nom AS categorie
    FROM articles a
    INNER JOIN article_tags at ON at.article_id = a.id
    INNER JOIN tags t ON t.id = at.tag_id
    LEFT JOIN categories c ON c.id = a.categorie_id
    WHERE t.slug = ?
    ORDER BY a.date_pub DESC
    LIMIT $depart, $articlesParPage
");

$stmt->execute([$slug]);
$articles = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| QUERY PARAMS (pagination propre)
|--------------------------------------------------------------------------
*/
$queryParams = [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>#<?= htmlspecialchars($tag['nom']) ?> - Blog</title>
  <link rel="stylesheet" href="/StandComputer/shared">
  <style>
    body {
  padding-top: var(--nav-h);
}

/* =========================
   HERO TAG
========================= */
.page-hero {
  padding: 80px 0 40px;
  text-align: center;
}

.page-hero h1 {
  font-size: 2.2rem;
  font-weight: 800;
}

.page-hero .accent {
  color: var(--primary);
}

.page-hero p {
  margin-top: 10px;
  color: var(--text-muted);
}

/* =========================
   GRID ARTICLES
========================= */
.articles-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-top: 40px;
}

.article-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
  transition: var(--transition);
}

.article-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-md);
}

.article-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.article-body {
  padding: 18px;
}

.article-body h3 {
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 10px;
  color: var(--text-main);
}

.article-body h3:hover {
  color: var(--primary);
}

.article-body p {
  font-size: .85rem;
  color: var(--text-muted);
  line-height: 1.6;
  margin-bottom: 12px;
}

.article-body a {
  color: var(--primary);
  font-weight: 600;
  font-size: .85rem;
  text-decoration: none;
}

/* =========================
   PAGINATION
========================= */
.pagination {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-top: 50px;
}

.page-btn {
  width: 40px;
  height: 40px;
  border-radius: var(--radius-sm);
  border: 1.5px solid var(--border);
  background: transparent;
  color: var(--text-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  transition: var(--transition);
}

.page-btn:hover {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
}

.page-btn.active {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width: 900px) {
  .articles-grid {
    grid-template-columns: 1fr;
  }

  .page-hero h1 {
    font-size: 1.8rem;
  }
}
</style>
</head>

<body>

<div id="nav-placeholder"></div>

<section class="page-hero">
  <div class="container">
    <h1>
      Tag : <span class="accent">#<?= htmlspecialchars($tag['nom']) ?></span>
    </h1>
    <p><?= $total ?> article(s) trouvé(s)</p>
  </div>
</section>

<section class="blog-section">
  <div class="container">

    <div class="articles-grid">

      <?php foreach ($articles as $a): ?>
        <div class="article-card">

          <img src="/StandComputer/admin/uploads/articles/<?= htmlspecialchars($a['image']) ?>" />

          <div class="article-body">
            <h3><?= htmlspecialchars($a['titre']) ?></h3>

            <p><?= substr(strip_tags($a['contenu']), 0, 120) ?>...</p>

            <a href="/StandComputer/article/<?= $a['id'] ?>">
              Lire l'article
            </a>
          </div>

        </div>
      <?php endforeach; ?>

    </div>

    <!-- PAGINATION -->
    <div class="pagination">

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/StandComputer/tag/<?= $slug ?>?page=<?= $i ?>"
           class="page-btn <?= ($i == $page) ? 'active' : '' ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>

    </div>

  </div>
</section>
<div id="fab-placeholder"></div>

<div id="footer-placeholder"></div>
<script src="/StandComputer/components"></script>
<script>initComponents();</script>

</body>
</html>