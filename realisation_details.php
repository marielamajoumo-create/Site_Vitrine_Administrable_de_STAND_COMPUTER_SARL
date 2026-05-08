<?php
include 'config/db.php';

$id = $_GET['id'];

$real = $pdo->prepare("SELECT * FROM realisations WHERE id=?");
$real->execute([$id]);
$data = $real->fetch(PDO::FETCH_ASSOC);

$images = $pdo->prepare("
    SELECT * FROM realisation_images
    WHERE realisation_id=?
");
$images->execute([$id]);
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

    /*galerie*/
    .realisation-container {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        padding: 20px;
    }
    .realisation-title{
        font-size: 32px;
        font-weight: bold;
        color: #E65100;
        margin-bottom: 10px;
    }
    .realisation-description {
        font-size: 16px;
        color:#E8F5E9;
        background-color: #1565C0;
        margin-bottom: 30px;
        line-height: 1.6;
    }
    .realisation-gallery{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax (120px,1fr));
        gap:8px;
    }
    .image-card {
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .image-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .image-card:hover img {
        transform: scale (1.1);
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
        <a href="realisations.php">Realisations</a>
        <span class="sep">›</span>
        <span class="current"> Details des Réalisations</span>
      </div>
      <h1>Nos <span class="accent">Réalisations</span></h1>
      <p>Découvrez  des projets menés à bien pour des clients de tous secteurs au cameroun dans le domaine <?php echo htmlspecialchars($data['title']); ?>.</p>
    </div>
  </section>
   <div class="realisation-container">
        <h1 class="realisation-title"><?php echo htmlspecialchars($data['title']); ?></h1>

        <p class="realisation-description"><?php echo htmlspecialchars($data['description']); ?></p>
        <!-- galerie d'image -->
        <div class="realisation-gallery"> 
            <?php foreach($images as $img): ?>
            <div class="image-card">
                <img src="admin/uploads/realisations/<?php echo $img['image_path']; ?>" width="300">
            </div>
            <?php endforeach; ?>
        </div>
   </div>
     <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>

  <script src="components.js"></script>
  <script>
    initComponents('accueil');

    // Animated counters
    const statsSection = document.getElementById('stats');
    let countersRan = false;
    const statsObs = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && !countersRan) {
        countersRan = true;
        document.querySelectorAll('.stat-number[data-target]').forEach(el => {
          const target = parseInt(el.dataset.target, 10);
          const accent = el.querySelector('.accent');
          let val = 0;
          const step = target / 60;
          const timer = setInterval(() => {
            val = Math.min(val + step, target);
            el.childNodes[0].textContent = Math.floor(val);
            if (val >= target) clearInterval(timer);
          }, 20);
        });
      }
    }, { threshold: 0.5 });
    statsObs.observe(statsSection);
  </script>
</body>
</html>

