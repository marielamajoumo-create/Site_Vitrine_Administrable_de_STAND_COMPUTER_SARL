<?php
include 'config/db.php';

$formations = $pdo->query("SELECT * FROM formations ")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Formations – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
<link rel="stylesheet" href="assets/css/shared.css" />
  <style>
    body { padding-top: var(--nav-h); }

    /* ─── Intro stats ── */
    .formations-intro { padding: 64px 0 0; background: var(--bg-light); }
    .intro-stats {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
      padding: 0 0 64px;
    }
    .intro-stat {
      background: #fff;
      border-radius: var(--radius-lg);
      padding: 28px 24px;
      text-align: center;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-sm);
    }
    .intro-stat .number { font-size: 2rem; font-weight: 800; color: var(--primary); }
    .intro-stat .number .accent { color: var(--accent); }
    .intro-stat .label { font-size: .85rem; color: var(--text-muted); margin-top: 4px; }

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

  <section class="page-hero">
    <div class="container page-hero-inner">
      <div class="breadcrumb">
        <a href="index.html">Accueil</a>
        <span class="sep">›</span>
        <span class="current">Formations</span>
      </div>
      <h1>Nos <span class="accent">Formations</span></h1>
      <p>Montez en compétences avec nos formations pratiques en informatique, réseaux, développement et design dispensées par des experts certifiés.</p>
    </div>
  </section>

  <!-- Chiffres clés -->
  <section class="formations-intro">
    <div class="container">
      <div class="intro-stats">
        <div class="intro-stat fade-in">
          <div class="number">500<span class="accent">+</span></div>
          <div class="label">Apprenants formés</div>
        </div>
        <div class="intro-stat fade-in">
          <div class="number">12<span class="accent">+</span></div>
          <div class="label">Modules disponibles</div>
        </div>
        <div class="intro-stat fade-in">
          <div class="number">95<span class="accent">%</span></div>
          <div class="label">Taux de satisfaction</div>
        </div>
        <div class="intro-stat fade-in">
          <div class="number">8<span class="accent">+</span></div>
          <div class="label">Formateurs certifiés</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Catalogue -->
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

  <!-- Comment ça marche -->
  <section class="process-section">
    <div class="container">
      <div class="process-header">
        <span class="section-label">Comment ça marche</span>
        <h2 class="section-title">Votre parcours de <span class="accent">formation</span></h2>
      </div>
      <div class="process-steps">
        <div class="process-step fade-in">
          <div class="step-num">1</div>
          <h3>Choisissez votre formation</h3>
          <p>Sélectionnez le module qui correspond à vos objectifs professionnels.</p>
        </div>
        <div class="process-step fade-in">
          <div class="step-num">2</div>
          <h3>Inscrivez-vous</h3>
          <p>Contactez-nous pour confirmer votre inscription et la date de démarrage.</p>
        </div>
        <div class="process-step fade-in">
          <div class="step-num">3</div>
          <h3>Suivez les cours</h3>
          <p>Cours en présentiel dans nos locaux avec matériel fourni et pratique intensive.</p>
        </div>
        <div class="process-step fade-in">
          <div class="step-num">4</div>
          <h3>Obtenez votre certificat</h3>
          <p>Validez vos acquis et recevez votre certificat reconnu par les entreprises locales.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container cta-inner">
      <div>
        <h2>Formation pour votre équipe en entreprise ?</h2>
        <p>Nous proposons des formations sur-mesure directement dans vos locaux.</p>
      </div>
      <a href="contact.html" class="btn btn-primary">
        Nous contacter <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
      </a>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>
  <script src="components.js"></script>
  <script>initComponents('formations');</script>
</body>
</html>
