<?php
require_once 'config/db.php';

// Article en vedette
$featured = $pdo->query("
  SELECT a.*, c.nom AS categorie
  FROM articles a
  LEFT JOIN categories c ON a.categorie_id = c.id
  WHERE a.featured = 1
  ORDER BY a.date_pub DESC
  LIMIT 1
")->fetch();

// Articles récents
$articles = $pdo->query("
  SELECT a.*, c.nom AS categorie
  FROM articles a
  LEFT JOIN categories c ON a.categorie_id = c.id
  WHERE a.featured = 0
  ORDER BY a.date_pub DESC
")->fetchAll();

// Catégories sidebar
$categories = $pdo->query("
  SELECT c.*, COUNT(a.id) AS total
  FROM categories c
  LEFT JOIN articles a ON a.categorie_id = c.id
  GROUP BY c.id
")->fetchAll();

// Articles récents sidebar
$recent = $pdo->query("
  SELECT id, titre, image, date_pub
  FROM articles
  ORDER BY date_pub DESC
  LIMIT 3
")->fetchAll();
?>






<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
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

    @media (max-width: 900px) {
      .blog-layout { grid-template-columns: 1fr; }
      .blog-sidebar { position: static; }
      .articles-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <div id="nav-placeholder"></div>

  <section class="page-hero">
    <div class="container page-hero-inner">
      <div class="breadcrumb">
        <a href="index.php">Accueil</a>
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

    <a href="article.php?id=<?= $featured['id'] ?>" class="read-more">
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
      <img src="admin/uploads/articles/<?= htmlspecialchars($a['image']) ?>" />
    </div>

    <div class="article-body">
      <div class="article-meta">
        <span class="cat-badge"><?= htmlspecialchars($a['categorie']) ?></span>
        <span><?= date('d M Y', strtotime($a['date_pub'])) ?></span>
      </div>

      <h3><?= htmlspecialchars($a['titre']) ?></h3>

      <p><?= substr(strip_tags($a['contenu']), 0, 120) ?>...</p>

      <a href="article.php?id=<?= $a['id'] ?>" class="read-more">
        Lire la suite <span class="material-icons-round">arrow_forward</span>
      </a>
    </div>
  </div>
<?php endforeach; ?>
</div>
          

          

          <!-- Pagination -->
          <div class="pagination">
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn"><span class="material-icons-round" style="font-size:16px">chevron_right</span></button>
          </div>
        </div>

        <!-- Sidebar -->
         
        <aside class="blog-sidebar">
          <div class="sidebar-widget">
            <h3>Rechercher</h3>
            <div class="search-form">
              <input type="text" placeholder="Rechercher un article..." />
              <button><span class="material-icons-round" style="font-size:18px">search</span></button>
            </div>
          </div>

          <div class="sidebar-widget">
            <h3>Catégories</h3>
            <ul class="cat-list">
              <ul class="cat-list">
<?php foreach($categories as $c): ?>
  <li>
    <a href="blog.php?cat=<?= $c['id'] ?>">
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
    <h4><?= htmlspecialchars($r['titre']) ?></h4>
    <span><?= date('d M Y', strtotime($r['date_pub'])) ?></span>
  </div>
</div>
<?php endforeach; ?>
            
          </div>

          <div class="sidebar-widget">
            <h3>Tags</h3>
            <div class="tags-cloud">
              <span class="tag-chip">Réseau</span>
              <span class="tag-chip">Cybersécurité</span>
              <span class="tag-chip">Web</span>
              <span class="tag-chip">Mobile</span>
              <span class="tag-chip">Design</span>
              <span class="tag-chip">Marketing</span>
              <span class="tag-chip">Cisco</span>
              <span class="tag-chip">Windows</span>
              <span class="tag-chip">Linux</span>
              <span class="tag-chip">Cloud</span>
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
  <script src="components.js"></script>
  <script>initComponents('blog');</script>
</body>
</html>
