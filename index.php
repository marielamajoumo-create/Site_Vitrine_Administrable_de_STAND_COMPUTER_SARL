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
          <a href="about.php" class="btn btn-blue">En savoir plus</a>
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
