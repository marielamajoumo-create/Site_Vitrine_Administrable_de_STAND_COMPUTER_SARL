<?php
require_once 'config/db.php';

$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$id = isset($url[2]) ? (int)$url[2] : 0;

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
$tagStmt = $pdo->prepare("
    SELECT t.*
    FROM tags t
    INNER JOIN article_tags at
        ON at.tag_id = t.id
    WHERE at.article_id = ?
    ORDER BY t.nom
");

$tagStmt->execute([$article['id']]);

$tags = $tagStmt->fetchAll(PDO::FETCH_ASSOC);

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
 $titleParts= explode (' ', $article['titre'], 2);

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

  <link rel="stylesheet" href="/StandComputer/shared" />
 
  <style>
    

/* =========================================================
   ARTICLE PAGE - BLOG STYLE CLEAN
========================================================= */

body {
  padding-top: var(--nav-h);
}
.article-section { padding: 80px 0; }

/* =========================
   HERO
========================= */
.article-hero {
  padding: 80px 0 60px;
  text-align: center;
  
}


.article-hero h1 {
  font-size: 2.6rem;
  font-weight: 800;
  max-width: 900px;
  margin: auto;
}

.article-hero p {
  max-width: 700px;
  margin: 16px auto 0;
  color: var(--text-muted);
}

/* =========================
   ARTICLE MAIN
========================= */

.article-layout {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 40px;
  align-items: start;
}

.article-content-card {
  width: 100%;
  max-width: 900px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.article-cover {
  width: 100%;
  height: 420px;
  object-fit: cover;
  display: block;
}

.article-content {
  padding: 40px;
  line-height: 1.9;
  color: var(--text-main);
}

.article-category {
  display: inline-block;
  padding: 6px 14px;
  border-radius: var(--radius-pill);
  background: var(--bg-light);
  color: var(--primary);
  font-size: 0.8rem;
  font-weight: 600;
  margin-bottom: 16px;
}

.article-title {
  font-size: 2rem;
  font-weight: 800;
  margin-bottom: 16px;
}

.article-meta-content {
  display: flex;
  gap: 18px;
  flex-wrap: wrap;
  font-size: 0.85rem;
  color: var(--text-muted);
  margin-bottom: 28px;
}

.article-meta-content span {
  display: flex;
  align-items: center;
  gap: 6px;
}

/* =========================
   TYPO CONTENT
========================= */

.article-content p {
  margin-bottom: 1.2em;
}

.article-content h2,
.article-content h3,
.article-content h4 {
  margin-top: 2em;
  margin-bottom: 0.8em;
  font-weight: 700;
}

.article-content ul,
.article-content ol {
  margin-left: 1.5em;
  margin-bottom: 1.5em;
}

.article-content li {
  margin-bottom: 0.5em;
}

.article-content blockquote {
  margin: 2em 0;
  padding: 20px 24px;
  border-left: 4px solid var(--primary);
  background: var(--bg-light);
  font-style: italic;
  color: var(--text-muted);
  border-radius: 0 var(--radius-md) var(--radius-md) 0;
}

/* =========================
   BOTTOM LAYOUT (SIDEBAR)
========================= */

.article-bottom-layout {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 40px;
  margin-top: 60px;
}

/* =========================
   SIDEBAR
========================= */

.article-sidebar {
  position: sticky;
  top: calc(var(--nav-h) + 20px);
}

.sidebar-widget {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 24px;
  box-shadow: var(--shadow-sm);
  margin-bottom: 24px;
}

.sidebar-widget h3 {
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 16px;
  border-bottom: 2px solid var(--accent);
  display: inline-block;
  padding-bottom: 8px;
}

/* SEARCH */
.search-form {
  display: flex;
  gap: 8px;
}

.search-form input {
  flex: 1;
  padding: 10px 14px;
  border-radius: var(--radius-pill);
  border: 1px solid var(--border);
  outline: none;
}

.search-form button {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: var(--primary);
  color: #fff;
  border: none;
  cursor: pointer;
}

/* RECENTS */
.recent-post {
  display: flex;
  gap: 12px;
  padding: 10px 0;
  border-bottom: 1px solid var(--border);
  text-decoration: none;
  color: inherit;
  transition: 0.2s;
}

.recent-post:last-child {
  border-bottom: none;
}

.recent-post:hover {
  transform: translateX(4px);
}

.recent-post img {
  width: 64px;
  height: 64px;
  object-fit: cover;
  border-radius: var(--radius-sm);
}

.recent-post h4 {
  font-size: 0.85rem;
  margin-bottom: 4px;
}

/* =========================
   SIMILAIRES (GAUCHE)
========================= */

.related-section h2 {
  font-size: 1.8rem;
  margin-bottom: 20px;
}

.related-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 16px;
}

.related-card {
  display: flex;
  gap: 12px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  overflow: hidden;
  text-decoration: none;
  transition: 0.2s;
}

.related-card:hover {
  transform: translateY(-3px);
}

.related-card img {
  width: 110px;
  height: 100%;
  object-fit: cover;
}

.related-body {
  padding: 12px;
}

.related-body h3 {
  font-size: 0.95rem;
  margin-bottom: 6px;
}
.article-tags{
  display:flex;
  flex-wrap:wrap;
  gap:10px;
  margin:24px 0;
}

.article-tag{
  display:inline-block;
  padding:8px 14px;
  border-radius:999px;
  background:var(--bg-light);
  color:var(--primary);
  text-decoration:none;
  font-size:.85rem;
  font-weight:600;
  transition:.2s;
}

.article-tag:hover{
  transform:translateY(-2px);
  box-shadow:var(--shadow-sm);
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 900px) {
  .article-bottom-layout {
    grid-template-columns: 1fr;
  }

  .article-cover {
    height: 280px;
  }

  .article-content {
    padding: 24px;
  }
}
</style>
</head>
<body>

<div id="nav-placeholder"></div>

<!-- HERO -->
<section class="page-hero article-hero">
  <div class="container">

    <div class="breadcrumb">
      <a href="/StandComputer/">Accueil</a>
      <span>›</span>
      <a href="/StandComputer/blog">Blog</a>
      <span>›</span>
      <span><?= htmlspecialchars($article['titre']) ?></span>
    </div>
      <h1>
     <?php echo  htmlspecialchars($titleParts[0]); ?>
              <?php if (isset ($titleParts[1])) :?>
                <span class="accent"> <?php echo  htmlspecialchars($titleParts[1]); ?></span>
              <?php endif; ?>
              </h1>
    

    <p>
      Découvrez notre article sur
      <span class="accent"><?= htmlspecialchars($article['categorie']) ?></span>
      publié le <?= date('d M Y', strtotime($article['date_pub'])) ?>
    </p>

  </div>
</section>

<!-- ARTICLE -->
<section class="article-section">

  <!-- ARTICLE PRINCIPAL -->
  <div class="container article-layout">

    <article class="article-content-card">

      <?php if (!empty($article['image'])): ?>
        <img
          src="/StandComputer/admin/uploads/articles/<?= htmlspecialchars($article['image']) ?>"
          class="article-cover"
        />
      <?php endif; ?>

      <div class="article-content">

        <span class="article-category">
          <?= htmlspecialchars($article['categorie']) ?>
        </span>

        <h1 class="article-title">
          <?= htmlspecialchars($article['titre']) ?>
        </h1>

        <div class="article-meta-content">
          
          <span><span class="material-icons-round" style="font-size:14px">calendar_today</span> <?= date('d M Y', strtotime($article['date_pub'])) ?></span>

          <?php if (!empty($article['auteur'])): ?>
            <span> <span class="material-icons-round" style="font-size:14px">person</span><?= htmlspecialchars($article['auteur']) ?></span>
          <?php endif; ?>

        </div>
        <?php if (!empty($tags)): ?>

<div class="article-tags">

    <?php foreach ($tags as $tag): ?>

        <a
            href="/StandComputer/tag/<?= htmlspecialchars($tag['slug']) ?>"
            class="article-tag"
        >
            #<?= htmlspecialchars($tag['nom']) ?>
        </a>

    <?php endforeach; ?>

</div>

<?php endif; ?>

        <?= nl2br($article['contenu']) ?>

      </div>
    </article>


  

    

    <!-- SIDEBAR -->
    <aside class="article-sidebar">

      <!-- SEARCH -->
      <div class="sidebar-widget">
        <h3>Rechercher</h3>

        <form method="GET" action="/StandComputer/blog" class="search-form">
          <input type="text" name="search" placeholder="Rechercher..." />
          <button><span class="material-icons-round" style="font-size:18px">search</span></button>
        </form>
      </div>

      <!-- SIMILAIRES -->
    <div class="sidebar-widget">
  <h3>Articles similaires</h3>

  <?php if (!empty($related)): ?>

    <div class="related-grid">
            <?php foreach ($related as $item): ?>
              <a href="/StandComputer/article/<?= $item['id'] ?>" class="related-card">

                <?php if (!empty($item['image'])): ?>
                  <img src="/StandComputer/admin/uploads/articles/<?= htmlspecialchars($item['image']) ?>" />
                <?php endif; ?>

                <div class="related-body">
                  <h3><?= htmlspecialchars($item['titre']) ?></h3>
                  <span><?= date('d M Y', strtotime($item['date_pub'])) ?></span>
                </div>

              </a>
            <?php endforeach; ?>

          </div>

        
          </div>
  <?php endif; ?>


      <!-- RECENTS -->
      <div class="sidebar-widget">
        <h3>Articles récents</h3>

        <?php foreach ($recent as $r): ?>
          <a href="/StandComputer/article/<?= $r['id'] ?>" class="recent-post">

            <?php if (!empty($r['image'])): ?>
              <img src="/StandComputer/admin/uploads/articles/<?= htmlspecialchars($r['image']) ?>" />
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



<div id="footer-placeholder"></div>
<div id="fab-placeholder"></div>

<script src="/StandComputer/components"></script>
<script>
  initComponents('blog');
</script>

</body>
</html>