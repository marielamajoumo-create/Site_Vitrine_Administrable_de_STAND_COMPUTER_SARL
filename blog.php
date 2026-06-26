<?php
require_once 'config/db.php';

$articlesParPage = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if($page < 1){
    $page = 1;
}
$depart = ($page - 1) * $articlesParPage;


//$articles->execute();

//$articles = $articles->fetchAll();

// Article en vedette
$featured = $pdo->query("
  SELECT a.*, c.nom AS categorie
  FROM articles a
  LEFT JOIN categories c ON a.categorie_id = c.id
  WHERE a.featured = 1
  ORDER BY a.date_pub DESC
  LIMIT 1
")->fetch();

$featuredTags = [];

if ($featured) {
    $tagStmt = $pdo->prepare("
        SELECT t.nom, t.slug
        FROM tags t
        INNER JOIN article_tags at ON at.tag_id = t.id
        WHERE at.article_id = ?
    ");
    $tagStmt->execute([$featured['id']]);
    $featuredTags = $tagStmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Articles récents
$articles = $pdo->query("
  SELECT a.*, c.nom AS categorie
  FROM articles a
  LEFT JOIN categories c ON a.categorie_id = c.id
  WHERE a.featured = 0
  ORDER BY a.date_pub DESC
  LIMIT $depart, $articlesParPage
")->fetchAll();*/

// Catégories sidebar
$categories = $pdo->query("
  SELECT c.*, COUNT(a.id) AS total
  FROM categories c
  LEFT JOIN articles a ON a.categorie_id = c.id AND a.featured = 0
  GROUP BY c.id
")->fetchAll(PDO::FETCH_ASSOC);

// Articles récents sidebar
$recent = $pdo->query("
  SELECT id, titre, image, date_pub
  FROM articles
  ORDER BY date_pub DESC
  LIMIT 3
")->fetchAll();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
//$cat = isset($_GET['cat']) ? (int) $_GET['cat'] : 0;
$cat = isset($_GET['cat']) ? trim($_GET['cat']) : '';

$countSql = "
SELECT COUNT(*) as total
FROM articles a
LEFT JOIN categories c ON a.categorie_id = c.id
WHERE a.featured = 0
";

if (!empty($search)) {
    $countSql .= "
        AND (
            a.titre LIKE :search
            OR a.contenu LIKE :search
        )
    ";
}

if (!empty($cat)) {
    $countSql .= "
        AND c.nom = :cat
    ";
}

$countStmt = $pdo->prepare($countSql);

if (!empty($search)) {
    $countStmt->bindValue(':search', "%$search%");
}

if (!empty($cat)) {
    $countStmt->bindValue(':cat', $cat);
}

$countStmt->execute();

$total = $countStmt->fetch()['total'];

$totalPages = ceil($total / $articlesParPage);

$sql = "
SELECT a.*, c.nom AS categorie
FROM articles a
LEFT JOIN categories c ON a.categorie_id = c.id
WHERE a.featured = 0
";

if(!empty($search)){
   $sql .= " AND (a.titre LIKE :search OR a.contenu LIKE :search)";
}

/*if($cat > 0){
   $sql .= " AND a.categorie_id = :cat";
}*/

if(!empty($cat)){
   $sql .= " AND c.nom = :cat";
}

$sql .= " ORDER BY a.date_pub DESC
LIMIT $depart, $articlesParPage";

$stmt = $pdo->prepare($sql);

if(!empty($search)){
   $stmt->bindValue(':search', "%$search%");
}

/*if($cat > 0){
   $stmt->bindValue(':cat', $cat, PDO::PARAM_INT);
   
}*/
if(!empty($cat)){
   $stmt->bindValue(':cat', $cat);
}

$stmt->execute();

$articles = $stmt->fetchAll();

foreach ($articles as &$article) {

    $tagStmt = $pdo->prepare("
        SELECT t.nom, t.slug
        FROM tags t
        INNER JOIN article_tags at
            ON at.tag_id = t.id
        WHERE at.article_id = ?
        ORDER BY t.nom
        LIMIT 4
    ");

    $tagStmt->execute([$article['id']]);

    $article['tags'] = $tagStmt->fetchAll(PDO::FETCH_ASSOC);
}
unset($article);
$popularTags = $pdo->query("
    SELECT
        t.nom,
        t.slug,
        COUNT(at.article_id) AS total
    FROM tags t
    INNER JOIN article_tags at
        ON at.tag_id = t.id
    GROUP BY t.id
    ORDER BY total DESC, t.nom ASC
    LIMIT 15
")->fetchAll(PDO::FETCH_ASSOC);
?>






<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="/StandComputer/shared" />
  <style>
    body { padding-top: var(--nav-h); }

    /* ─── Blog layout ── */
    .blog-section { padding: 80px 0; }
    .blog-layout {
      display: grid;
      grid-template-columns: 1fr 320px;
      gap: 48px;
      align-items: start;
    }

    /* Featured article */
    .featured-article {
      border-radius: var(--radius-lg);
      overflow: hidden;
      background: var(--surface);
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
      margin-bottom: 32px;
      transition: var(--transition);
    }
    .featured-article:hover { box-shadow: var(--shadow-lg); }
    .featured-thumb { height: 320px; overflow: hidden; }
    .featured-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .featured-article:hover .featured-thumb img { transform: scale(1.04); }
    .featured-body { padding: 28px; }
    .article-meta {
      display: flex;
      align-items: center;
      gap: 16px;
      font-size: .78rem;
      color: var(--text-muted);
      margin-bottom: 12px;
    }
    .article-meta .cat-badge {
      background: var(--bg-light);
      color: var(--primary);
      padding: 3px 10px;
      border-radius: var(--radius-pill);
      font-weight: 600;
    }
    .featured-body h2 { font-size: 1.4rem; font-weight: 700; margin-bottom: 10px; color: var(--text-main); line-height: 1.3; }
    .featured-body h2:hover { color: var(--primary); cursor: pointer; }
    .featured-body p { font-size: .9rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 20px; }
    .read-more { display: inline-flex; align-items: center; gap: 6px; color: var(--primary); font-size: .88rem; font-weight: 600; transition: var(--transition); }
    .read-more:hover { color: var(--accent); gap: 10px; }

    /* Articles grid */
    .articles-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }
    .article-card {
      border-radius: var(--radius-lg);
      overflow: hidden;
      background: var(--surface);
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }
    .article-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
    .article-thumb { height: 180px; overflow: hidden; }
    .article-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .article-card:hover .article-thumb img { transform: scale(1.06); }
    .article-body { padding: 20px; }
    .article-body h3 { font-size: .95rem; font-weight: 700; margin-bottom: 8px; color: var(--text-main); line-height: 1.4; }
    .article-body h3:hover { color: var(--primary); cursor: pointer; }
    .article-body p { font-size: .82rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 12px; }

    /* Sidebar */
    .blog-sidebar { position: sticky; top: calc(var(--nav-h) + 24px); }
    .sidebar-widget {
      background: var(--surface);
      border-radius: var(--radius-lg);
      padding: 24px;
      border: 1px solid var(--border);
      margin-bottom: 24px;
    }
    .sidebar-widget h3 {
      font-size: .95rem;
      font-weight: 700;
      margin-bottom: 16px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--accent);
      display: inline-block;
    }
    .search-form { display: flex; gap: 8px; }
    .search-form input {
      flex: 1;
      padding: 10px 14px;
      border-radius: var(--radius-pill);
      border: 1.5px solid var(--border);
      font-family: inherit;
      font-size: .85rem;
      outline: none;
      transition: var(--transition);
    }
    .search-form input:focus { border-color: var(--primary); }
    .search-form button {
      width: 40px; height: 40px;
      border-radius: 50%;
      background: var(--primary);
      border: none;
      color: #fff;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: var(--transition);
      flex-shrink: 0;
    }
    .search-form button:hover { background: var(--accent); }
    .cat-list li { border-bottom: 1px solid var(--border); }
    .cat-list li:last-child { border: none; }
    .cat-list a {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 0;
      font-size: .87rem;
      color: var(--text-main);
      transition: var(--transition);
    }
    .cat-list a:hover { color: var(--primary); padding-left: 6px; }
    .cat-list a .count {
      background: var(--bg-light);
      color: var(--primary);
      font-size: .72rem;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: var(--radius-pill);
    }
    .recent-post { display: flex; gap: 12px; padding: 10px 0; border-bottom: 1px solid var(--border); }
    .recent-post:last-child { border: none; }
    .recent-thumb { width: 64px; height: 64px; border-radius: var(--radius-sm); overflow: hidden; flex-shrink: 0; }
    .recent-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .recent-info h4 { font-size: .82rem; font-weight: 600; color: var(--text-main); margin-bottom: 4px; line-height: 1.4; }
    .recent-info h4:hover { color: var(--primary); cursor: pointer; }
    .recent-info span { font-size: .72rem; color: var(--text-muted); }
    .tags-cloud { display: flex; gap: 8px; flex-wrap: wrap; }
    .tag-chip {
      padding: 5px 12px;
      border-radius: var(--radius-pill);
      background: var(--bg-light);
      color: var(--text-muted);
      font-size: .78rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      border: 1px solid var(--border);
    }
    .tag-chip:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

    /* Pagination */
    .pagination { display: flex; gap: 8px; justify-content: center; margin-top: 40px; }
    .page-btn {
      width: 40px; height: 40px;
      border-radius: var(--radius-sm);
      border: 1.5px solid var(--border);
      background: transparent;
      color: var(--text-muted);
      font-family: inherit;
      font-size: .9rem;
      cursor: pointer;
      transition: var(--transition);
      display: flex; align-items: center; justify-content: center;
    }
    .page-btn.active, .page-btn:hover { background: var(--primary); border-color: var(--primary); color: #fff; }

    .article-tags{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    margin-bottom:14px;
}

.article-tags a{
    color:var(--primary);
    text-decoration:none;
    font-size:.8rem;
    font-weight:600;
}

.article-tags a:hover{
    text-decoration:underline;
}
    @media (max-width: 900px) {
      .blog-layout { grid-template-columns: 1fr; }
      .blog-sidebar { position: static; }
      .articles-grid { grid-template-columns: 1fr; }
    }
    .active-cat{
   color: var(--primary) !important;
   font-weight: 700;
   padding-left: 6px;
}
  </style>
</head>
<body>

  <div id="nav-placeholder"></div>

  <section class="page-hero">
    <div class="container page-hero-inner">
      <div class="breadcrumb">
        <a href="/StandComputer/">Accueil</a>
        <span class="sep">›</span>
        <span class="current">Blog</span>
      </div>
      <h1>Notre <span class="accent">Blog</span></h1>
      <p>Actualités, conseils et tendances du monde numérique par les experts de Stand Computer.</p>
    </div>
  </section>

  <section class="blog-section">
    <div class="container">
      <div class="blog-layout">

        <!-- Article à la une -->
         
        <div>
          <?php if($featured): ?>
<div class="featured-article fade-in">
  <div class="featured-thumb">
    <img src="admin/uploads/articles/<?= htmlspecialchars($featured['image']) ?>" />
  </div>

  <div class="featured-body">
    <div class="article-meta">
      <span class="cat-badge"><?= htmlspecialchars($featured['categorie']) ?></span>
      <span><span class="material-icons-round" style="font-size:14px">calendar_today</span><?= date('d M Y', strtotime($featured['date_pub'])) ?></span>
      <span><span class="material-icons-round" style="font-size:14px">person</span><?= htmlspecialchars($featured['auteur']) ?></span>
    </div>

    <h2><?= htmlspecialchars($featured['titre']) ?></h2>

    <p><?= substr(strip_tags($featured['contenu']), 0, 200) ?>...</p>
    <?php if(!empty($a['tags'])): ?>

<div class="article-tags">

    <?php foreach($a['tags'] as $tag): ?>

        <a href="/StandComputer/tag/<?= htmlspecialchars($tag['slug']) ?>">
            #<?= htmlspecialchars($tag['nom']) ?>
        </a>

    <?php endforeach; ?>

</div>

<?php endif; ?>

    <a href="/StandComputer/article/<?= $featured['id']?>" class="read-more">
      Lire l'article <span class="material-icons-round">arrow_forward</span>
    </a>
  </div>
</div>
<?php endif; ?>

   <!-- Grille articles -->

<div class="articles-grid">
<?php foreach($articles as $a): ?>
  <div class="article-card fade-in">
    <div class="article-thumb">
      <img src="/StandComputer/admin/uploads/articles/<?= htmlspecialchars($a['image']) ?>" />
    </div>

    <div class="article-body">
      <div class="article-meta">
        <span class="cat-badge"><?= htmlspecialchars($a['categorie']) ?></span>
        <span><?= date('d M Y', strtotime($a['date_pub'])) ?></span>
      </div>

      <h3><?= htmlspecialchars($a['titre']) ?></h3>

      <p><?= substr(strip_tags($a['contenu']), 0, 120) ?>...</p>
      <?php if(!empty($a['tags'])): ?>

<div class="article-tags">

    <?php foreach($a['tags'] as $tag): ?>

        <a href="/StandComputer/tag/<?= htmlspecialchars($tag['slug']) ?>">
            #<?= htmlspecialchars($tag['nom']) ?>
        </a>

    <?php endforeach; ?>

</div>

<?php endif; ?>

      <a href="/StandComputer/article/<?php echo $a['id']; ?>" class="read-more">
        Lire la suite <span class="material-icons-round">arrow_forward</span>
      </a>
    </div>
  </div>
<?php endforeach; ?>
</div>
          

          

          <!-- Pagination -->
           

<?php

$queryParams = [];

if (!empty($search)) {
    $queryParams['search'] = $search;
}

if (!empty($cat)) {
    $queryParams['cat'] = $cat;
}

?>


          <div class="pagination">
    <!-- Bouton précédent -->
    <?php if($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>" class="page-btn">
            <span class="material-icons-round" style="font-size:16px">
                chevron_left
            </span>
        </a>
    <?php endif; ?>
    <?php for($i = 1; $i <= $totalPages; $i++): ?>

        <a 
          <?php
$params = array_merge(
    $queryParams,
    ['page' => $i]
);
?>

href="?<?= http_build_query($params) ?>"
           class="page-btn <?= ($i == $page) ? 'active' : '' ?>"
        >
            <?= $i ?>
        </a>

    <?php endfor; ?>
    <?php if($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>" class="page-btn">
            <span class="material-icons-round" style="font-size:16px">
                chevron_right
            </span>
        </a>
    <?php endif; ?>

    </div>
        </div>

        <!-- Sidebar -->
         
        <aside class="blog-sidebar">
          <div class="sidebar-widget">
            <h3>Rechercher</h3>
            <form method="GET" class="search-form">
              <input type="text" name="search"  value="<?= htmlspecialchars($search) ?>" placeholder="Rechercher un article..." />
              <button type="submit"><span class="material-icons-round" style="font-size:18px">search</span></button>
            </form>
          </div>

          <div class="sidebar-widget">
            <h3>Catégories</h3>
            <ul class="cat-list">
              <?php foreach($categories as $c): ?>
               <li>
                 <a 
                   href="/StandComputer/blog?cat=<?= urlencode($c['nom']) ?>"
                   class="<?= ($cat === $c['nom']) ? 'active-cat' : '' ?>"
                 
                  >
    
                   <?= htmlspecialchars($c['nom']) ?>
                  <span class="count"><?= $c['total'] ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
          </ul>
        </div>

          <div class="sidebar-widget">
            <h3>Articles récents</h3>
            <?php foreach($recent as $r): ?>
<div class="recent-post">
  <div class="recent-thumb">
    <img src="admin/uploads/articles/<?= htmlspecialchars($r['image']) ?>" />
  </div>
  <div class="recent-info">
    <a href="/StandComputer/article/<?= $r['id'] ?>">
   <h4><?= htmlspecialchars($r['titre']) ?></h4>
</a>
    <span><?= date('d M Y', strtotime($r['date_pub'])) ?></span>
  </div>
</div>
<?php endforeach; ?>
            
          </div>
<div class="sidebar-widget">
  <h3> Tags </h3>
          <div class="tags-cloud">

<?php foreach($popularTags as $tag): ?>

    <a
        href="/StandComputer/tag/<?= htmlspecialchars($tag['slug']) ?>"
        class="tag-chip"
    >
        #<?= htmlspecialchars($tag['nom']) ?>
    </a>

<?php endforeach; ?>

</div>
          </div>
        </aside>

      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container cta-inner">
      <div>
        <h2>Restez informé des dernières tendances numériques</h2>
        <p>Abonnez-vous à notre newsletter et recevez nos articles chaque semaine.</p>
      </div>
      <a href="#footer" class="btn btn-primary">
        S'abonner <span class="material-icons-round" style="font-size:18px">notifications</span>
      </a>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>
  <script src="/StandComputer/components"></script>
  <script>initComponents('blog');</script>
</body>
</html>
