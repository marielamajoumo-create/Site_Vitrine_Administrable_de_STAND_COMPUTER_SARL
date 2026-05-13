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

        <!-- Articles -->
        <div>
          <!-- Article à la une -->
          <div class="featured-article fade-in">
            <div class="featured-thumb">
              <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=900&q=80" alt="Tech article" />
            </div>
            <div class="featured-body">
              <div class="article-meta">
                <span class="cat-badge">Réseaux</span>
                <span><span class="material-icons-round" style="font-size:14px">calendar_today</span> 15 Avril 2024</span>
                <span><span class="material-icons-round" style="font-size:14px">person</span> Jean-Pierre Mutombo</span>
              </div>
              <h2>Pourquoi la cybersécurité est-elle devenue incontournable pour les PME africaines ?</h2>
              <p>Face à la digitalisation croissante des entreprises en Afrique, les menaces informatiques se multiplient. Découvrez comment protéger efficacement votre infrastructure contre les cyberattaques les plus fréquentes.</p>
              <a href="#" class="read-more">Lire l'article <span class="material-icons-round" style="font-size:16px">arrow_forward</span></a>
            </div>
          </div>

          <!-- Grille articles -->
          <div class="articles-grid">
            <div class="article-card fade-in">
              <div class="article-thumb">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&q=80" alt="Développement" />
              </div>
              <div class="article-body">
                <div class="article-meta">
                  <span class="cat-badge">Développement</span>
                  <span>10 Avril 2024</span>
                </div>
                <h3>5 raisons de créer une application mobile pour votre business en 2024</h3>
                <p>Les applications mobiles ne sont plus réservées aux grandes entreprises. Voici pourquoi une app peut transformer votre activité.</p>
                <a href="#" class="read-more">Lire la suite <span class="material-icons-round" style="font-size:16px">arrow_forward</span></a>
              </div>
            </div>

            <div class="article-card fade-in">
              <div class="article-thumb">
                <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=500&q=80" alt="Réseau" />
              </div>
              <div class="article-body">
                <div class="article-meta">
                  <span class="cat-badge">Réseaux</span>
                  <span>5 Avril 2024</span>
                </div>
                <h3>Comment optimiser la vitesse de votre réseau Wi-Fi en entreprise</h3>
                <p>Un réseau lent coûte cher en productivité. Découvrez les solutions pratiques pour améliorer votre connectivité.</p>
                <a href="#" class="read-more">Lire la suite <span class="material-icons-round" style="font-size:16px">arrow_forward</span></a>
              </div>
            </div>

            <div class="article-card fade-in">
              <div class="article-thumb">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&q=80" alt="Marketing" />
              </div>
              <div class="article-body">
                <div class="article-meta">
                  <span class="cat-badge">Marketing</span>
                  <span>28 Mars 2024</span>
                </div>
                <h3>Facebook Ads en RDC : guide pratique pour toucher vos clients</h3>
                <p>Les publicités Facebook sont un levier puissant pour les entreprises congolaises. Voici comment bien configurer vos campagnes.</p>
                <a href="#" class="read-more">Lire la suite <span class="material-icons-round" style="font-size:16px">arrow_forward</span></a>
              </div>
            </div>

            <div class="article-card fade-in">
              <div class="article-thumb">
                <img src="https://images.unsplash.com/photo-1626785774573-4b799315345d?w=500&q=80" alt="Design" />
              </div>
              <div class="article-body">
                <div class="article-meta">
                  <span class="cat-badge">Design</span>
                  <span>20 Mars 2024</span>
                </div>
                <h3>L'importance d'une identité visuelle forte pour votre marque</h3>
                <p>Un logo professionnel et une charte graphique cohérente peuvent faire toute la différence dans la perception de votre entreprise.</p>
                <a href="#" class="read-more">Lire la suite <span class="material-icons-round" style="font-size:16px">arrow_forward</span></a>
              </div>
            </div>
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
              <li><a href="#">Maintenance <span class="count">8</span></a></li>
              <li><a href="#">Réseaux <span class="count">12</span></a></li>
              <li><a href="#">Développement <span class="count">15</span></a></li>
              <li><a href="#">Design <span class="count">7</span></a></li>
              <li><a href="#">Marketing <span class="count">10</span></a></li>
              <li><a href="#">Formations <span class="count">5</span></a></li>
            </ul>
          </div>

          <div class="sidebar-widget">
            <h3>Articles récents</h3>
            <div class="recent-post">
              <div class="recent-thumb"><img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=100&q=80" alt="" /></div>
              <div class="recent-info">
                <h4>Cybersécurité pour les PME africaines</h4>
                <span>15 Avril 2024</span>
              </div>
            </div>
            <div class="recent-post">
              <div class="recent-thumb"><img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=100&q=80" alt="" /></div>
              <div class="recent-info">
                <h4>5 raisons de créer une app mobile</h4>
                <span>10 Avril 2024</span>
              </div>
            </div>
            <div class="recent-post">
              <div class="recent-thumb"><img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=100&q=80" alt="" /></div>
              <div class="recent-info">
                <h4>Facebook Ads en RDC : guide pratique</h4>
                <span>28 Mars 2024</span>
              </div>
            </div>
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
