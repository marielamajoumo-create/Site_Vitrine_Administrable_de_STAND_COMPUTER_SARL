<?php
include 'config/db.php';

$services = $pdo->query("SELECT * FROM services LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
$formations = $pdo->query("SELECT * FROM formations LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
$realisations = $pdo->query("SELECT * FROM realisations ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$stats = $pdo->query("SELECT * FROM statistiques LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Réalisations – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
  <style>
    body { padding-top: var(--nav-h); }

    /* ─── Filters ── */
    .portfolio-section { padding: 80px 0; }
    .portfolio-header { text-align: center; margin-bottom: 40px; }
    .portfolio-header p { color: var(--text-muted); max-width: 540px; margin: 10px auto 0; line-height: 1.7; }
    .filters {
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
      margin-bottom: 48px;
    }
    .filter-btn {
      padding: 8px 20px;
      border-radius: var(--radius-pill);
      border: 1.5px solid var(--border);
      background: transparent;
      color: var(--text-muted);
      font-family: inherit;
      font-size: .85rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
    }
    .filter-btn.active, .filter-btn:hover {
      background: var(--primary);
      border-color: var(--primary);
      color: #fff;
    }

    /* ─── Projects Grid ── */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }
    .project-item {
      border-radius: var(--radius-lg);
      overflow: hidden;
      background: var(--surface);
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }
    .project-item:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
    .project-item.hidden { display: none; }
    .project-thumb { height: 220px; overflow: hidden; position: relative; }
    .project-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .project-item:hover .project-thumb img { transform: scale(1.08); }
    .project-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(10,22,40,.8) 0%, transparent 60%);
      opacity: 0;
      transition: var(--transition);
      display: flex;
      align-items: flex-end;
      padding: 16px;
    }
    .project-item:hover .project-overlay { opacity: 1; }
    .overlay-btn {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 16px;
      background: #fff;
      color: var(--primary);
      border-radius: var(--radius-pill);
      font-size: .8rem;
      font-weight: 600;
    }
    .project-body { padding: 20px; }
    .project-body h3 { font-size: .95rem; font-weight: 700; margin-bottom: 6px; }
    .project-body p { font-size: .82rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 12px; }
    .project-tags { display: flex; gap: 6px; flex-wrap: wrap; }
    .project-tag {
      padding: 3px 10px;
      border-radius: var(--radius-pill);
      font-size: .68rem;
      font-weight: 600;
    }
    .tag-reseaux    { background: #E3F2FD; color: #1565C0; }
    .tag-logiciel  { background: #F3E5F5; color: #7B1FA2; }
    .tag-web       { background: #E8F5E9; color: #2E7D32; }
    .tag-infographie { background: #FFF3E0; color: #E65100; }
    .tag-maintenance { background: #FCE4EC; color: #C62828; }
    .tag-marketing { background: #E8EAF6; color: #283593; }

    /* ─── Testimonials ── */
    .testimonials-section { padding: 80px 0; background: var(--bg-light); }
    .testimonials-header { text-align: center; margin-bottom: 48px; }
    .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .testimonial-card {
      background: #fff;
      border-radius: var(--radius-lg);
      padding: 28px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }
    .testimonial-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
    .stars { color: #FFB300; font-size: 1rem; margin-bottom: 12px; letter-spacing: 2px; }
    .testimonial-card p { font-size: .88rem; color: var(--text-muted); line-height: 1.7; font-style: italic; margin-bottom: 20px; }
    .testimonial-author { display: flex; align-items: center; gap: 12px; }
    .testimonial-author img { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
    .testimonial-author strong { display: block; font-size: .88rem; color: var(--text-main); }
    .testimonial-author span { font-size: .78rem; color: var(--text-muted); }

    @media (max-width: 900px) {
      .projects-grid { grid-template-columns: repeat(2, 1fr); }
      .testimonials-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
    }
    @media (max-width: 600px) {
      .projects-grid { grid-template-columns: 1fr; }
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
        <span class="current">Réalisations</span>
      </div>
      <h1>Nos <span class="accent">Réalisations</span></h1>
      <p>Découvrez plus de <?php echo $stats['projects_completed']; ?> projets menés à bien pour des clients de tous secteurs en RDC et en Afrique.</p>
    </div>
  </section>

  <section class="portfolio-section">
    <div class="container">
      <div class="portfolio-header">
        <span class="section-label">Notre Portfolio</span>
        <h2 class="section-title">Des projets qui <span class="accent">parlent d'eux-mêmes</span></h2>
        <p>Filtrez par catégorie pour découvrir nos réalisations dans chaque domaine d'expertise.</p>
      </div>

      <div class="filters">
        <button class="filter-btn active" data-filter="all">Tous</button>
        <?php foreach($realisations as $realisation): ?>
        <button class="filter-btn" data-filter="<?php echo htmlspecialchars($realisation['category']); ?>"><?php echo htmlspecialchars($realisation['category']); ?></button>
        <?php endforeach; ?>
      </div>

      <div class="projects-grid">
         <?php foreach($realisations as $realisation): ?>

        <div class="project-item fade-in" data-cat="<?php echo strtolower($realisation['category']); ?>">
          <div class="project-thumb">
            <img src="admin/uploads/realisations/<?php echo $realisation['thumbnail']; ?>" alt="<?php echo htmlspecialchars($realisation['title']); ?>" />
            <div class="project-overlay"><span class="overlay-btn"><span class="material-icons-round" style="font-size:16px"><a href="realisation_details.php?id=<?php echo $realisation['id']; ?>">visibility</span>Voir</span></a></div>
          </div>
          <div class="project-body">
            <h3><?php echo htmlspecialchars($realisation['title']); ?></h3>
            <p><?php echo htmlspecialchars($realisation['description']); ?></p>
            <div class="project-tags"><span class="project-tag tag-<?php echo strtolower($realisation['category']); ?>"><?php echo htmlspecialchars($realisation['category']); ?></span></div>
          </div>
        </div>
          <?php endforeach ?>
    </div>
    </div>
  </section>

  <!-- Témoignages -->
  <section class="testimonials-section">
    <div class="container">
      <div class="testimonials-header">
        <span class="section-label">Témoignages</span>
        <h2 class="section-title">Ce que disent <span class="accent">nos clients</span></h2>
      </div>
      <div class="testimonials-grid">
        <div class="testimonial-card fade-in">
          <div class="stars">★★★★★</div>
          <p>"Stand Computer a complètement transformé notre infrastructure réseau. Le travail était propre, rapide et professionnel. Je les recommande vivement !"</p>
          <div class="testimonial-author">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80" alt="Client" />
            <div>
              <strong>Patrick Kabongo</strong>
              <span>Directeur, Mining Corp</span>
            </div>
          </div>
        </div>
        <div class="testimonial-card fade-in">
          <div class="stars">★★★★★</div>
          <p>"Notre site web a été livré en 2 semaines avec un design magnifique. L'équipe est très réactive et les résultats dépassent nos attentes."</p>
          <div class="testimonial-author">
            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=100&q=80" alt="Cliente" />
            <div>
              <strong>Christine Mwamba</strong>
              <span>Gérante, Institut ABC</span>
            </div>
          </div>
        </div>
        <div class="testimonial-card fade-in">
          <div class="stars">★★★★★</div>
          <p>"Le logiciel de gestion développé par Stand Computer nous a fait gagner un temps précieux. Support excellent et toujours disponibles pour des ajustements."</p>
          <div class="testimonial-author">
            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100&q=80" alt="Client" />
            <div>
              <strong>Jean-Marc Tshiambu</strong>
              <span>PDG, Pharma Plus</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container cta-inner">
      <div>
        <h2>Votre projet sera notre prochaine réalisation</h2>
        <p>Parlez-nous de votre idée, nous vous proposerons la meilleure approche.</p>
      </div>
      <a href="contact.php" class="btn btn-primary">
        Démarrer mon projet <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
      </a>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>
  <script src="components.js"></script>
  <script>
    initComponents('realisations');
    // Filter logic
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        projectItems.forEach(item => {
          const show = filter === 'all' || item.dataset.cat === filter;
          item.classList.toggle('hidden', !show);
        });
      });
    });
  </script>
</body>
</html>
