<?php
include 'config/db.php';

$services = $pdo->query("SELECT * FROM services LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
$formations = $pdo->query("SELECT * FROM formations LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
$realisations = $pdo->query("SELECT * FROM realisations ORDER BY created_at DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
$stats = $pdo->query("SELECT * FROM statistiques LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stand Computer SARL – Votre partenaire en solutions numériques</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <style> 

/* ─── Catalogue ── */
    .catalogue-section { padding: 80px 0; }
    .catalogue-header { text-align: center; margin-bottom: 48px; }
    .catalogue-header p { color: var(--text-muted); max-width: 540px; margin: 10px auto 0; line-height: 1.7; }
    .formations-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }
    .formation-card {
      background: var(--surface);
      border-radius: var(--radius-lg);
      overflow: hidden;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
    }
    .formation-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
    .formation-thumb { height: 180px; overflow: hidden; position: relative; }
    .formation-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .formation-card:hover .formation-thumb img { transform: scale(1.06); }
    .formation-level {
      position: absolute;
      top: 12px; left: 12px;
      padding: 4px 12px;
      border-radius: var(--radius-pill);
      font-size: .68rem;
      font-weight: 700;
    }
    .level-debutant   { background: #E8F5E9; color: #2E7D32; }
    .level-intermediaire { background: #FFF9C4; color: #F9A825; }
    .level-avance     { background: #FCE4EC; color: #C62828; }
    .formation-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
    .formation-cat { font-size: .72rem; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 6px; }
    .formation-body h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; color: var(--text-main); }
    .formation-body p { font-size: .83rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; flex: 1; }
    .formation-meta {
      display: flex;
      align-items: center;
      gap: 16px;
      font-size: .78rem;
      color: var(--text-muted);
      padding-top: 14px;
      border-top: 1px solid var(--border);
      margin-bottom: 14px;
    }
    .formation-meta span { display: flex; align-items: center; gap: 4px; }
    .formation-meta .material-icons-round { font-size: 14px; color: var(--accent); }
    .formation-price {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: auto;
    }
    .price-amount { font-size: 1.1rem; font-weight: 800; color: var(--primary); }
    .price-amount small { font-size: .75rem; font-weight: 400; color: var(--text-muted); }

    /* ─── Process ── */
    .process-section { padding: 80px 0; background: var(--bg-light); }
    .process-header { text-align: center; margin-bottom: 56px; }
    .process-steps {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      position: relative;
    }
    .process-steps::before {
      content: '';
      position: absolute;
      top: 36px; left: 12.5%; right: 12.5%;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
    }
    .process-step { text-align: center; position: relative; }
    .step-num {
      width: 72px; height: 72px;
      border-radius: 50%;
      background: var(--primary);
      color: #fff;
      font-size: 1.4rem;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      position: relative;
      z-index: 1;
      box-shadow: 0 4px 16px rgba(21,101,192,.3);
    }
    .process-step h3 { font-size: .9rem; font-weight: 700; margin-bottom: 6px; }
    .process-step p { font-size: .82rem; color: var(--text-muted); line-height: 1.5; }

    @media (max-width: 900px) {
      .intro-stats { grid-template-columns: repeat(2, 1fr); }
      .formations-grid { grid-template-columns: repeat(2, 1fr); }
      .process-steps { grid-template-columns: repeat(2, 1fr); }
      .process-steps::before { display: none; }
    }
    @media (max-width: 600px) {
      .intro-stats { grid-template-columns: repeat(2, 1fr); }
      .formations-grid { grid-template-columns: 1fr; }
      .process-steps { grid-template-columns: 1fr; }
    }

  </style>
</head>
<body>

  <div id="nav-placeholder"></div>

  <!-- ╔══ HERO ════════════════════════════════════════════════════╗ -->
  <section id="hero">
    <div class="hero-bg"></div>
    <div class="container hero-inner">
      <div class="hero-content">
        <span class="hero-tagline">L'innovation au service de votre performance</span>
        <h1 class="hero-title">
          Votre partenaire<br />en solutions<br /><span class="accent">numériques</span>
        </h1>
        <p class="hero-subtitle">
          Maintenance informatique, réseaux, développement, infographie,
          marketing digital, formations et bien plus.
        </p>
        <div class="hero-actions">
          <a href="services.php" class="btn btn-primary">
            Découvrir nos services
            <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
          </a>
          <a href="contact.php" class="btn btn-outline">
            Nous contacter
            <span class="material-icons-round" style="font-size:18px">open_in_new</span>
          </a>
        </div>
      </div>
      <div class="hero-visual">
        <div class="hero-img-wrap">
          <img src="logo.jpeg" alt="logo stand computer" />
          <div class="hero-arc"></div>
        </div>
        <div class="hero-badge">
          <span class="material-icons-round icon">verified</span>
          <div>
            <strong><?php echo $stats['years_experience']; ?>+</strong>
            <span>d'expérience</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ╔══ SERVICES ════════════════════════════════════════════════╗ -->
  <section id="services">
    <div class="container">
      <div class="services-header">
        <span class="section-label">Nos Services</span>
        <h2 class="section-title">Des solutions adaptées <span class="accent">à vos besoins</span></h2>
      </div>
      <div class="services-grid">
        <?php foreach($services as $service): ?>
          <a href="services.php#maintenance" class="service-card fade-in">
            <div class="service-icon"><span class="material-icons-round"><?php echo $service['icon']; ?></span></div>
            <h3><?php echo $service['title']; ?></h3>
            <p><?php echo $service['description']; ?></p>
            <div class="service-arrow"><span class="material-icons-round" style="font-size:18px">arrow_forward</span></div>
          
          </a>
        <?php endforeach; ?>
      </div>
      <div class="services-cta">
        <a href="services.php" class="btn btn-outline-dark">Voir tous nos services</a>
      </div>
    </div>
  </section>

  <!-- ╔══ STATS ═══════════════════════════════════════════════════╗ -->
  <section id="stats">
    <div class="container">
      <div class="stats-inner">
        <div class="stats-left">
          <h2>Pourquoi <span class="accent">nous choisir ?</span></h2>
          <p>Nous combinons expertise, innovation et engagement pour vous offrir des services de qualité supérieure adaptés au marché africain.</p>
          <a href="about.html" class="btn btn-blue">En savoir plus</a>
        </div>
        <div class="stats-grid">
          <div class="stat-item fade-in">
            <div class="stat-icon"><span class="material-icons-round">workspace_premium</span></div>
            <div class="stat-number" data-target="<?php echo $stats['years_experience']; ?>">0<span class="accent">+</span></div>
            <div class="stat-label">Années<br/>d'expérience</div>
          </div>
          <div class="stat-item fade-in">
            <div class="stat-icon"><span class="material-icons-round">task_alt</span></div>
            <div class="stat-number" data-target="<?php echo $stats['projects_completed']; ?>">0<span class="accent">+</span></div>
            <div class="stat-label">Projets<br/>réalisés</div>
          </div>
          <div class="stat-item fade-in">
            <div class="stat-icon"><span class="material-icons-round">groups</span></div>
            <div class="stat-number" data-target="<?php echo $stats['clients_satisfied']; ?>">0<span class="accent">+</span></div>
            <div class="stat-label">Clients<br/>satisfaits</div>
          </div>
          <div class="stat-item fade-in">
            <div class="stat-icon"><span class="material-icons-round">support_agent</span></div>
            <div class="stat-number" data-target="<?php echo $stats['experts_count']; ?>">0<span class="accent">+</span></div>
            <div class="stat-label">Experts à<br/>votre service</div>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- ╔══ Formations ════════════════════════════════════════════╗ -->
     <section class="catalogue-section">
    <div class="container">
      <div class="catalogue-header">
        <span class="section-label">Catalogue</span>
        <h2 class="section-title">Nos <span class="accent">formations disponibles</span></h2>
        <p>Des formations courtes et intensives pour acquérir rapidement des compétences professionnelles opérationnelles.</p>
      </div>

    <div class="formations-grid">

    
      <?php foreach($formations as $formation): ?>

        <div class="formation-card fade-in">
          <div class="formation-thumb">
            <img src="admin/uploads/formations/<?php echo $formation['image']; ?>" alt="<?php echo htmlspecialchars($formation['title']); ?>" />
            <span class="formation-level level-debutant"><?php echo htmlspecialchars($formation['niveau']);?></span>
          </div>
          <div class="formation-body">
            <div class="formation-cat"><?php echo htmlspecialchars($formation['title']);?></div>
            <h3><?php echo htmlspecialchars($formation['intitule']);?></h3>
            <p><?php echo htmlspecialchars($formation['description']);?></p>
            <div class="formation-meta">
              <span><span class="material-icons-round">schedule</span><?php echo htmlspecialchars($formation['duration']);?></span>
              <span><span class="material-icons-round">people</span><?php echo htmlspecialchars($formation['nombrePersonne']);?></span>
              <span><span class="material-icons-round">workspace_premium</span><?php echo htmlspecialchars($formation['natureDiplome']);?></span>
            </div>
            <div class="formation-price">
              <div class="price-amount">Sur devis <small>/personne</small></div>
              <a href="contact.php" class="btn btn-primary" style="padding:8px 16px;font-size:.8rem;">S'inscrire</a>
            </div>
          </div>
        </div>
      <?php endforeach?>
    </div>
    </div>
     </section>

     <!-- ╔══ CTA BANNER 1 ══════════════════════════════════════════════╗ -->
  <section id="cta-banner">
    <div class="container cta-inner-home">
      <div class="cta-img-wrap">
        <img src="logo.jpeg" alt="Support client" />
      </div>
      <div class="cta-home-text">
        <h2>Souhaitez-vous transformer vos connaissances en competences  concretes et employable ?</h2>
        <p>Notre équipe est engagee à vous accompagner dans ce parcours .</p>
      </div>
      <a href="contact.html" class="btn btn-primary">
        Decouvrez le CTIPDC
        <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
      </a>
    </div>
  </section>


  <!-- ╔══ RÉALISATIONS ════════════════════════════════════════════╗ -->
  <section id="realisations">
    <div class="container">
      <div class="realisations-header">
        <span class="section-label">Nos Réalisations</span>
        <h2 class="section-title">Découvrez quelques-uns de <span class="accent">nos projets</span></h2>
      </div>
      <div class="realisations-grid">
        <?php foreach($realisations as $realisation): ?>

        <div class="project-card fade-in">
          <div class="project-img"><a href="realisation_details.php?id=<?php echo $realisation['id']; ?>">
                <img src="admin/uploads/realisations/<?php echo $realisation['thumbnail']; ?>" alt="<?php echo htmlspecialchars($realisation['title']); ?>" />
            </a>
          </div>
          <div class="project-info"><p><?php echo htmlspecialchars($realisation['title']); ?></p>
            <span class="project-tag tag-<?php echo strtolower($realisation['category']); ?>">
                <?php echo htmlspecialchars($realisation['category']); ?>
            </span>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
        
      <div class="realisations-cta">
        <a href="realisations.php" class="btn btn-blue">Voir toutes nos réalisations</a>
      </div>
    </div>
  </section>

  <!-- ╔══ CTA BANNER ══════════════════════════════════════════════╗ -->
  <section id="cta-banner">
    <div class="container cta-inner-home">
      <div class="cta-img-wrap">
        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&q=80" alt="Support client" />
      </div>
      <div class="cta-home-text">
        <h2>Besoin d'un accompagnement personnalisé ?</h2>
        <p>Notre équipe est à votre écoute pour concrétiser vos projets.</p>
      </div>
      <a href="contact.php" class="btn btn-primary">
        Contactez-nous maintenant
        <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
      </a>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>

  <script src="components.js"></script>
  <script>
    initComponents('accueil');
    initComponents('services');

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
