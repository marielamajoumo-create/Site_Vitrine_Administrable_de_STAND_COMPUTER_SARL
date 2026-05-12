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
  <title>Réalisation: <?php echo htmlspecialchars($data['title']); ?> – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
  <style>
    body { padding-top: var(--nav-h); background: var(--bg-light); }

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

    /* ─── REALISATION DETAILS CORRIGÉ ────────────────────────── */
    .realisation-detail-section {
      padding: 40px 0 80px;
      background: var(--bg-light);
    }
    
    .realisation-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    /* En-tête de la réalisation */
    .realisation-header {
      margin-bottom: 40px;
      padding-bottom: 20px;
      border-bottom: 2px solid var(--border);
    }
    
    .realisation-title {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 16px;
      position: relative;
      display: inline-block;
    }
    
    .realisation-title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 60px;
      height: 3px;
      background: var(--accent);
      border-radius: 2px;
    }
    
    .realisation-description {
      font-size: 1rem;
      color: var(--text-muted);
      background: var(--surface);
      padding: 20px 24px;
      border-radius: var(--radius-lg);
      border-left: 4px solid var(--accent);
      line-height: 1.7;
      margin-top: 20px;
      box-shadow: var(--shadow-sm);
    }
    
    /* Galerie d'images - Version corrigée */
    .gallery-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .gallery-title .material-icons-round {
      color: var(--accent);
      font-size: 28px;
    }
    
    .realisation-gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 24px;
      margin-top: 20px;
    }
    
    /* Correction de la classe image-card */
    .image-card {
      background: var(--surface);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      border: 1px solid var(--border);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    
    .image-card:hover {
      transform: translateY(-6px);
      box-shadow: var(--shadow-lg);
      border-color: transparent;
    }
    
    /* Conteneur d'image avec dimensions fixes */
    .image-wrapper {
      position: relative;
      width: 100%;
      height: 240px;
      overflow: hidden;
      background: linear-gradient(135deg, #0a1628 0%, #1a2a4a 100%);
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .image-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
    
    .image-card:hover .image-wrapper img {
      transform: scale(1.08);
    }
    
    /* Overlay au survol */
    .image-overlay {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .image-card:hover .image-overlay {
      opacity: 1;
    }
    
    .image-overlay .material-icons-round {
      color: white;
      font-size: 48px;
      background: rgba(255,107,0,0.8);
      border-radius: 50%;
      padding: 12px;
    }
    
    /* Légende de l'image */
    .image-caption {
      padding: 12px 16px;
      font-size: 0.8rem;
      color: var(--text-muted);
      background: var(--surface);
      border-top: 1px solid var(--border);
      text-align: center;
    }
    
    /* Message si aucune image */
    .no-images {
      text-align: center;
      padding: 60px 20px;
      background: var(--surface);
      border-radius: var(--radius-lg);
      border: 1px solid var(--border);
    }
    
    .no-images .material-icons-round {
      font-size: 64px;
      color: var(--text-muted);
      margin-bottom: 16px;
    }
    
    .no-images p {
      color: var(--text-muted);
      font-size: 1rem;
    }
    
    /* Bouton retour */
    .back-button {
      margin-bottom: 30px;
    }
    
    .back-button a {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    
    .back-button a:hover {
      color: var(--accent);
    }
    
    @media (max-width: 900px) {
      .projects-grid { grid-template-columns: repeat(2, 1fr); }
      .testimonials-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
      .realisation-gallery { grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); }
    }
    
    @media (max-width: 600px) {
      .projects-grid { grid-template-columns: 1fr; }
      .realisation-gallery { grid-template-columns: 1fr; }
      .realisation-title { font-size: 1.6rem; }
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
        <a href="realisations.php">Réalisations</a>
        <span class="sep">›</span>
        <span class="current"><?php echo htmlspecialchars($data['title']); ?></span>
      </div>
      <h1><?php echo htmlspecialchars($data['title']); ?></h1>
      <p>Découvrez en détail ce projet réalisé par notre équipe d'experts.</p>
    </div>
  </section>

  <section class="realisation-detail-section">
    <div class="realisation-container">
      
      <!-- Détails de la réalisation -->
      <div class="realisation-header">
        <h1 class="realisation-title"><?php echo htmlspecialchars($data['title']); ?></h1>
        <div class="realisation-description">
          <?php echo nl2br(htmlspecialchars($data['description'])); ?>
        </div>
      </div>
      
      <!-- Galerie d'images -->
      <div class="gallery-title">
        <span class="material-icons-round">photo_library</span>
        <span>Galerie du projet</span>
      </div>
      
      <div class="realisation-gallery">
        <?php 
        $imageCount = 0;
        foreach($images as $img): 
          $imageCount++;
          $imagePath = "admin/uploads/realisations/" . $img['image_path'];
        ?>
        <div class="image-card fade-in">
          <div class="image-wrapper">
            <img src="<?php echo $imagePath; ?>" 
                 alt="Image <?php echo $imageCount; ?> - <?php echo htmlspecialchars($data['title']); ?>"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='https://placehold.co/400x300/1565C0/white?text=Image+non+disponible'">
            <div class="image-overlay">
              <span class="material-icons-round">visibility</span>
            </div>
          </div>
          <div class="image-caption">
            <span class="material-icons-round" style="font-size: 14px; vertical-align: middle;">image</span>
            Vue d'ensemble - <?php echo htmlspecialchars($data['title']); ?>
          </div>
        </div>
        <?php endforeach; ?>
        
        <?php if($imageCount == 0): ?>
        <div class="no-images">
          <span class="material-icons-round">photo_camera</span>
          <p>Aucune image disponible pour cette réalisation.</p>
        </div>
        <?php endif; ?>
      </div>
      
      <!-- Bouton retour -->
      <div class="back-button" style="margin-top: 40px; text-align: center;">
        <a href="realisations.php">
          <span class="material-icons-round">arrow_back</span>
          Retour à la liste des réalisations
        </a>
      </div>
      
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>

  <script src="components.js"></script>
  <script>
    initComponents('realisations');
    
    // Animation au scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
      observer.observe(el);
    });
  </script>
</body>
</html>