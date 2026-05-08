<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>À propos – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
  <style>
    body { padding-top: var(--nav-h); }

    /* ─── About Story ── */
    .about-story { padding: 80px 0; }
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
    }
    .about-img { border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
    .about-img img { width: 100%; height: 380px; object-fit: cover; }
    .about-text .section-label { margin-bottom: 8px; }
    .about-text h2 { font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 700; margin-bottom: 20px; }
    .about-text h2 .accent { color: var(--accent); }
    .about-text p { color: var(--text-muted); line-height: 1.8; margin-bottom: 16px; font-size: .95rem; }
    .about-text .btn { margin-top: 8px; }

    /* ─── Values ── */
    .values-section { padding: 80px 0; background: var(--bg-light); }
    .values-header { text-align: center; margin-bottom: 48px; }
    .values-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }
    .value-card {
      background: #fff;
      border-radius: var(--radius-lg);
      padding: 32px 24px;
      text-align: center;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border);
      transition: var(--transition);
    }
    .value-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
    .value-icon {
      width: 64px; height: 64px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), #1976D2);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 16px;
    }
    .value-icon .material-icons-round { color: #fff; font-size: 30px; }
    .value-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }
    .value-card p { font-size: .85rem; color: var(--text-muted); line-height: 1.6; }

    /* ─── Team ── */
    .team-section { padding: 80px 0; }
    .team-header { text-align: center; margin-bottom: 48px; }
    .team-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }
    .team-card {
      background: var(--surface);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border);
      transition: var(--transition);
    }
    .team-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
    .team-img { height: 220px; overflow: hidden; }
    .team-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .team-card:hover .team-img img { transform: scale(1.06); }
    .team-info { padding: 20px; }
    .team-info h3 { font-size: 1rem; font-weight: 700; margin-bottom: 4px; }
    .team-info .role { font-size: .82rem; color: var(--accent); font-weight: 600; margin-bottom: 10px; }
    .team-info p { font-size: .82rem; color: var(--text-muted); line-height: 1.6; }

    /* ─── History Timeline ── */
    .history-section { padding: 80px 0; background: var(--bg-light); }
    .history-header { text-align: center; margin-bottom: 56px; }
    .timeline { position: relative; max-width: 800px; margin: 0 auto; }
    .timeline::before {
      content: '';
      position: absolute;
      left: 50%; top: 0; bottom: 0;
      width: 2px;
      background: var(--border);
      transform: translateX(-50%);
    }
    .tl-item {
      display: flex;
      gap: 32px;
      margin-bottom: 48px;
      position: relative;
    }
    .tl-item:nth-child(odd) { flex-direction: row-reverse; text-align: right; }
    .tl-item:nth-child(odd) .tl-content { align-items: flex-end; }
    .tl-dot {
      position: absolute;
      left: 50%; top: 20px;
      transform: translateX(-50%);
      width: 16px; height: 16px;
      border-radius: 50%;
      background: var(--accent);
      border: 3px solid #fff;
      box-shadow: 0 0 0 3px var(--accent);
      z-index: 1;
    }
    .tl-year {
      flex: 1;
      display: flex;
      align-items: flex-start;
      padding-top: 12px;
    }
    .tl-year span {
      font-size: 1.4rem;
      font-weight: 800;
      color: var(--primary);
      background: #fff;
      padding: 4px 12px;
      border-radius: var(--radius-sm);
      box-shadow: var(--shadow-sm);
    }
    .tl-content { flex: 1; display: flex; flex-direction: column; }
    .tl-card {
      background: #fff;
      border-radius: var(--radius-md);
      padding: 20px 24px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border);
    }
    .tl-card h3 { font-size: .95rem; font-weight: 700; margin-bottom: 6px; color: var(--text-main); }
    .tl-card p { font-size: .85rem; color: var(--text-muted); line-height: 1.6; }

    @media (max-width: 900px) {
      .about-grid { grid-template-columns: 1fr; }
      .values-grid { grid-template-columns: repeat(2, 1fr); }
      .team-grid { grid-template-columns: repeat(2, 1fr); }
      .timeline::before { left: 16px; }
      .tl-item, .tl-item:nth-child(odd) { flex-direction: column; text-align: left; padding-left: 48px; }
      .tl-item:nth-child(odd) .tl-content { align-items: flex-start; }
      .tl-dot { left: 16px; }
      .tl-year { flex: none; }
    }
    @media (max-width: 600px) {
      .values-grid, .team-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <div id="nav-placeholder"></div>

  <!-- Page Hero -->
  <section class="page-hero">
    <div class="container page-hero-inner">
      <div class="breadcrumb">
        <a href="index.html">Accueil</a>
        <span class="sep">›</span>
        <span class="current">À propos</span>
      </div>
      <h1>À propos de <span class="accent">Stand Computer</span></h1>
      <p>Découvrez notre histoire, notre équipe et les valeurs qui guident chacune de nos actions depuis plus de 7 ans.</p>
    </div>
  </section>

  <!-- Notre Histoire -->
  <section class="about-story">
    <div class="container">
      <div class="about-grid">
        <div class="about-img fade-in">
          <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=700&q=80" alt="Bureau Stand Computer" />
        </div>
        <div class="about-text fade-in">
          <span class="section-label">Notre Histoire</span>
          <h2>Nés pour servir <span class="accent">l'Afrique numérique</span></h2>
          <p>
            Fondée en 2017 à Lubumbashi en République Démocratique du Congo, Stand Computer SARL est née d'une vision simple : rendre les technologies de l'information accessibles et performantes pour les entreprises africaines.
          </p>
          <p>
            Aujourd'hui, notre équipe de plus de 20 experts accompagne plus de 150 clients dans leurs défis numériques : maintenance informatique, réseaux, développement logiciel, design et marketing digital.
          </p>
          <p>
            Notre engagement est de fournir des solutions durables, adaptées aux réalités locales, avec un service irréprochable et des tarifs compétitifs.
          </p>
          <a href="contact.html" class="btn btn-primary">Travailler avec nous <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>
    </div>
  </section>

  <!-- Nos Valeurs -->
  <section class="values-section">
    <div class="container">
      <div class="values-header">
        <span class="section-label">Nos Valeurs</span>
        <h2 class="section-title">Ce qui nous <span class="accent">définit</span></h2>
      </div>
      <div class="values-grid">
        <div class="value-card fade-in">
          <div class="value-icon"><span class="material-icons-round">verified</span></div>
          <h3>Excellence</h3>
          <p>Nous visons la perfection dans chaque mission, chaque livrable, chaque interaction avec nos clients.</p>
        </div>
        <div class="value-card fade-in">
          <div class="value-icon"><span class="material-icons-round">lightbulb</span></div>
          <h3>Innovation</h3>
          <p>Nous adoptons les technologies les plus récentes pour vous offrir des solutions à la pointe du digital.</p>
        </div>
        <div class="value-card fade-in">
          <div class="value-icon"><span class="material-icons-round">handshake</span></div>
          <h3>Engagement</h3>
          <p>Vos projets sont nos projets. Nous nous investissons pleinement pour atteindre vos objectifs.</p>
        </div>
        <div class="value-card fade-in">
          <div class="value-icon"><span class="material-icons-round">groups</span></div>
          <h3>Proximité</h3>
          <p>Un suivi personnalisé, une communication transparente et un accompagnement humain à chaque étape.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Notre Équipe -->
  <section class="team-section">
    <div class="container">
      <div class="team-header">
        <span class="section-label">Notre Équipe</span>
        <h2 class="section-title">Des <span class="accent">experts passionnés</span></h2>
      </div>
      <div class="team-grid">
        <div class="team-card fade-in">
          <div class="team-img">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80" alt="Directeur Général" />
          </div>
          <div class="team-info">
            <h3>Jean-Pierre Mutombo</h3>
            <div class="role">Directeur Général</div>
            <p>15 ans d'expérience en management IT et en transformation numérique des entreprises.</p>
          </div>
        </div>
        <div class="team-card fade-in">
          <div class="team-img">
            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400&q=80" alt="Directrice Technique" />
          </div>
          <div class="team-info">
            <h3>Marie Kabila</h3>
            <div class="role">Directrice Technique</div>
            <p>Ingénieure réseaux certifiée Cisco, spécialiste en infrastructure et cybersécurité.</p>
          </div>
        </div>
        <div class="team-card fade-in">
          <div class="team-img">
            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&q=80" alt="Chef de projet Dev" />
          </div>
          <div class="team-info">
            <h3>Emmanuel Tshimanga</h3>
            <div class="role">Chef de Projet Dev</div>
            <p>Développeur full-stack avec 8 ans d'expérience en applications web et mobiles.</p>
          </div>
        </div>
        <div class="team-card fade-in">
          <div class="team-img">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&q=80" alt="Responsable Design" />
          </div>
          <div class="team-info">
            <h3>Sandra Ilunga</h3>
            <div class="role">Responsable Design</div>
            <p>Designer créative spécialisée en identité visuelle, motion design et marketing digital.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Timeline -->
  <section class="history-section">
    <div class="container">
      <div class="history-header">
        <span class="section-label">Notre Parcours</span>
        <h2 class="section-title">7 ans d'<span class="accent">évolution continue</span></h2>
      </div>
      <div class="timeline">
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div class="tl-year"><span>2017</span></div>
          <div class="tl-content">
            <div class="tl-card fade-in">
              <h3>Fondation de Stand Computer</h3>
              <p>Création de l'entreprise à Lubumbashi avec une équipe de 3 personnes spécialisées en maintenance informatique.</p>
            </div>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div class="tl-year"><span>2019</span></div>
          <div class="tl-content">
            <div class="tl-card fade-in">
              <h3>Expansion vers les réseaux</h3>
              <p>Lancement du département Réseaux & Télécommunications et obtention des certifications Cisco.</p>
            </div>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div class="tl-year"><span>2021</span></div>
          <div class="tl-content">
            <div class="tl-card fade-in">
              <h3>Développement Logiciel & Web</h3>
              <p>Ouverture du pôle développement et livraison des 100 premiers projets logiciels et web.</p>
            </div>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div class="tl-year"><span>2024</span></div>
          <div class="tl-content">
            <div class="tl-card fade-in">
              <h3>Leader régional du numérique</h3>
              <p>Plus de 150 clients, 250 projets réalisés et une équipe de 20 experts à votre service.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="container cta-inner">
      <div>
        <h2>Prêt à démarrer votre transformation numérique ?</h2>
        <p>Notre équipe est disponible pour étudier votre projet et vous proposer la meilleure solution.</p>
      </div>
      <a href="contact.php" class="btn btn-primary">
        Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
      </a>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>

  <script src="components.js"></script>
  <script>initComponents('about');</script>
</body>
</html>
