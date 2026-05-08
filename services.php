<?php
include 'config/db.php';

function slugify($text) {
    $text= iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    $text=strtolower(trim($text));
    $text=preg_replace('/[^a-z0-9]+/', '-',$text);// remplace les espaces et caracteres preciaux par -
    return trim($text,'-');
}

$services = $pdo->query("SELECT * FROM services ")->fetchAll(PDO::FETCH_ASSOC);
$realisations = $pdo->query("SELECT * FROM realisations ")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Services – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
  <style>
    body { padding-top: var(--nav-h); }

    /* ─── Services grid ── */
    .services-section { padding: 80px 0; }
    .services-intro { text-align: center; margin-bottom: 64px; }
    .services-intro p { color: var(--text-muted); max-width: 580px; margin: 12px auto 0; line-height: 1.7; }

    .service-block {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
      padding: 64px 0;
      border-bottom: 1px solid var(--border);
    }
    .service-block:last-child { border-bottom: none; }
    .service-block:nth-child(even) .service-block-img { order: 2; }
    .service-block:nth-child(even) .service-block-text { order: 1; }
    .service-block-img { border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
    .service-block-img img { width: 100%; height: 320px; object-fit: cover; }
    .service-block-icon {
      width: 64px; height: 64px;
      border-radius: var(--radius-md);
      background: var(--bg-light);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 16px;
    }
    .service-block-icon .material-icons-round { color: var(--primary); font-size: 32px; }
    .service-block-text h2 { font-size: 1.6rem; font-weight: 700; margin-bottom: 12px; }
    .service-block-text h2 .accent { color: var(--accent); }
    .service-block-text p { color: var(--text-muted); line-height: 1.8; margin-bottom: 20px; font-size: .95rem; }
    .service-features { margin-bottom: 24px; }
    .service-features li {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 0;
      font-size: .88rem;
      color: var(--text-main);
      border-bottom: 1px solid var(--border);
    }
    .service-features li:last-child { border-bottom: none; }
    .service-features li .material-icons-round { color: var(--accent); font-size: 18px; flex-shrink: 0; }

    /* ─── Tarifs ── */
    .pricing-section { padding: 80px 0; background: var(--bg-light); }
    .pricing-header { text-align: center; margin-bottom: 48px; }
    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .pricing-card {
      background: #fff;
      border-radius: var(--radius-lg);
      padding: 32px 28px;
      border: 2px solid var(--border);
      transition: var(--transition);
      position: relative;
    }
    .pricing-card.featured {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(21,101,192,.08);
    }
    .pricing-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
    .pricing-badge {
      position: absolute;
      top: -12px; left: 50%; transform: translateX(-50%);
      background: var(--accent);
      color: #fff;
      font-size: .72rem;
      font-weight: 700;
      padding: 4px 14px;
      border-radius: var(--radius-pill);
    }
    .pricing-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; }
    .pricing-price { font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 4px; }
    .pricing-price span { font-size: .85rem; font-weight: 400; color: var(--text-muted); }
    .pricing-desc { font-size: .85rem; color: var(--text-muted); margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--border); }
    .pricing-features li {
      display: flex; align-items: center; gap: 8px;
      font-size: .85rem; padding: 6px 0;
      color: var(--text-main);
    }
    .pricing-features .material-icons-round { color: #4CAF50; font-size: 16px; }
    .pricing-features .off { color: var(--text-muted); text-decoration: line-through; }
    .pricing-features .off .material-icons-round { color: #ccc; }
    .pricing-card .btn { width: 100%; justify-content: center; margin-top: 24px; }

    @media (max-width: 900px) {
      .service-block { grid-template-columns: 1fr; gap: 32px; }
      .service-block:nth-child(even) .service-block-img,
      .service-block:nth-child(even) .service-block-text { order: unset; }
      .pricing-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
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
        <span class="current">Services</span>
      </div>
      <h1>Nos <span class="accent">Services</span></h1>
      <p>Des solutions informatiques complètes et adaptées à vos besoins professionnels, du réseau au marketing digital.</p>
    </div>
  </section>

  <section class="services-section">
    <div class="container">
      <div class="services-intro">
        <span class="section-label">Ce que nous faisons</span>
        <h2 class="section-title">Des solutions <span class="accent">adaptées à vos besoins</span></h2>
        <p>Chaque service est conçu pour répondre aux exigences spécifiques du marché congolais et africain, avec rigueur et expertise.</p>
      </div>

      <ul class="services-list">
      <?php foreach($services as $service): ?>
        <li id="<?php echo slugify($service['title']); ?>">
      <div class="service-block" id="maintenance">
        <div class="service-block-img fade-in">
          <img src="admin/uploads/services/<?php echo $service['image']; ?>" alt="<?php echo htmlspecialchars($service['title']); ?>" />
        </div>
        <div class="service-block-text fade-in">
          <div class="service-block-icon"><span class="material-icons-round"><?php echo $service['icon']; ?></span></div>
            <?php $titleParts= explode (' ', $service['title'], 2);?>
          <h2>
            <?php echo  htmlspecialchars($titleParts[0]); ?>
              <?php if (isset ($titleParts[1])) :?>
                <span class="accent"> <?php echo  htmlspecialchars($titleParts[1]); ?></span>
              <?php endif; ?>
          </h2>
          <p><?php echo $service['description']; ?></p>
          <ul class="service-features">
                <?php foreach($realisations as $realisation): ?>
                   <?php if ($realisation['category']=== $service['category']) : ?>
                  <li><span class="material-icons-round">check_circle</span> ><?php echo htmlspecialchars($realisation['title']); ?></li>
                    <?php endif ?>
                
                  <?php endforeach ?>
          </ul>
          <a href="contact.php" class="btn btn-primary">Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>
      </li>
      <?php endforeach ?>
      </ul>

      <!-- Réseaux 
      <div class="service-block" id="reseaux">
        <div class="service-block-img fade-in">
          <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=700&q=80" alt="Réseaux" />
        </div>
        <div class="service-block-text fade-in">
          <div class="service-block-icon"><span class="material-icons-round">router</span></div>
          <h2>Réseaux & <span class="accent">Télécommunications</span></h2>
          <p>Conception, déploiement et sécurisation de vos infrastructures réseau filaires et sans-fil. Nos ingénieurs certifiés Cisco vous garantissent une connectivité optimale.</p>
          <ul class="service-features">
            <li><span class="material-icons-round">check_circle</span> Câblage réseau structuré Cat5e/Cat6</li>
            <li><span class="material-icons-round">check_circle</span> Installation Wi-Fi entreprise</li>
            <li><span class="material-icons-round">check_circle</span> Configuration routeurs et switchs</li>
            <li><span class="material-icons-round">check_circle</span> Vidéosurveillance IP (CCTV)</li>
            <li><span class="material-icons-round">check_circle</span> VPN et sécurité réseau</li>
          </ul>
          <a href="contact.html" class="btn btn-primary">Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>

      // Logiciel 
      <div class="service-block" id="logiciel">
        <div class="service-block-img fade-in">
          <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=700&q=80" alt="Développement logiciel" />
        </div>
        <div class="service-block-text fade-in">
          <div class="service-block-icon"><span class="material-icons-round">code</span></div>
          <h2>Développement <span class="accent">Logiciel</span></h2>
          <p>Nous développons des logiciels de gestion sur mesure adaptés à votre secteur d'activité : gestion commerciale, RH, comptabilité, stocks et bien plus.</p>
          <ul class="service-features">
            <li><span class="material-icons-round">check_circle</span> Logiciels de gestion commerciale</li>
            <li><span class="material-icons-round">check_circle</span> Systèmes de caisse (POS)</li>
            <li><span class="material-icons-round">check_circle</span> Gestion des ressources humaines</li>
            <li><span class="material-icons-round">check_circle</span> Applications de suivi de stock</li>
            <li><span class="material-icons-round">check_circle</span> Formation et support inclus</li>
          </ul>
          <a href="contact.html" class="btn btn-primary">Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>

      // Web 
      <div class="service-block" id="web">
        <div class="service-block-img fade-in">
          <img src="https://images.unsplash.com/photo-1547658719-da2b51169166?w=700&q=80" alt="Développement web" />
        </div>
        <div class="service-block-text fade-in">
          <div class="service-block-icon"><span class="material-icons-round">web</span></div>
          <h2>Développement <span class="accent">Web & Mobile</span></h2>
          <p>Sites web professionnels, e-commerce et applications mobiles iOS/Android. Nous créons des expériences digitales modernes et performantes.</p>
          <ul class="service-features">
            <li><span class="material-icons-round">check_circle</span> Sites vitrines et e-commerce</li>
            <li><span class="material-icons-round">check_circle</span> Applications mobiles (iOS & Android)</li>
            <li><span class="material-icons-round">check_circle</span> Design UI/UX sur mesure</li>
            <li><span class="material-icons-round">check_circle</span> Référencement SEO inclus</li>
            <li><span class="material-icons-round">check_circle</span> Hébergement et maintenance</li>
          </ul>
          <a href="contact.html" class="btn btn-primary">Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>

      //Design
      <div class="service-block" id="design">
        <div class="service-block-img fade-in">
          <img src="https://images.unsplash.com/photo-1626785774573-4b799315345d?w=700&q=80" alt="Infographie et design" />
        </div>
        <div class="service-block-text fade-in">
          <div class="service-block-icon"><span class="material-icons-round">palette</span></div>
          <h2>Infographie & <span class="accent">Design</span></h2>
          <p>Donnez une image professionnelle à votre entreprise avec nos créations graphiques percutantes : logos, flyers, bannières et identité visuelle complète.</p>
          <ul class="service-features">
            <li><span class="material-icons-round">check_circle</span> Création de logo et identité visuelle</li>
            <li><span class="material-icons-round">check_circle</span> Flyers, affiches et brochures</li>
            <li><span class="material-icons-round">check_circle</span> Kakémonos et supports print</li>
            <li><span class="material-icons-round">check_circle</span> Motion design et vidéo</li>
            <li><span class="material-icons-round">check_circle</span> Charte graphique complète</li>
          </ul>
          <a href="contact.html" class="btn btn-primary">Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>

       //Marketing 
      <div class="service-block" id="marketing">
        <div class="service-block-img fade-in">
          <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=700&q=80" alt="Marketing digital" />
        </div>
        <div class="service-block-text fade-in">
          <div class="service-block-icon"><span class="material-icons-round">trending_up</span></div>
          <h2>Marketing <span class="accent">Digital</span></h2>
          <p>Développez votre présence en ligne et boostez vos ventes grâce à nos stratégies digitales : gestion des réseaux sociaux, publicité en ligne et e-réputation.</p>
          <ul class="service-features">
            <li><span class="material-icons-round">check_circle</span> Gestion réseaux sociaux (Facebook, Instagram)</li>
            <li><span class="material-icons-round">check_circle</span> Publicités Facebook Ads & Google Ads</li>
            <li><span class="material-icons-round">check_circle</span> Création de contenu et copywriting</li>
            <li><span class="material-icons-round">check_circle</span> Email marketing et newsletters</li>
            <li><span class="material-icons-round">check_circle</span> Rapports et analyse des performances</li>
          </ul>
          <a href="contact.html" class="btn btn-primary">Demander un devis <span class="material-icons-round" style="font-size:18px">arrow_forward</span></a>
        </div>
      </div>
                -->
    </div>
  </section>

  <!-- Tarifs -->
  <section class="pricing-section">
    <div class="container">
      <div class="pricing-header">
        <span class="section-label">Nos Tarifs</span>
        <h2 class="section-title">Des offres <span class="accent">transparentes</span></h2>
      </div>
      <div class="pricing-grid">
        <div class="pricing-card fade-in">
          <h3>Essentiel</h3>
          <div class="pricing-price">Sur devis <span>/projet</span></div>
          <div class="pricing-desc">Idéal pour les petites entreprises et startups</div>
          <ul class="pricing-features">
            <li><span class="material-icons-round">check</span> Maintenance de base</li>
            <li><span class="material-icons-round">check</span> Site web vitrine</li>
            <li><span class="material-icons-round">check</span> Logo et charte</li>
            <li class="off"><span class="material-icons-round">close</span> Application mobile</li>
            <li class="off"><span class="material-icons-round">close</span> Marketing digital</li>
          </ul>
          <a href="contact.html" class="btn btn-outline-dark">Demander un devis</a>
        </div>
        <div class="pricing-card featured fade-in">
          <div class="pricing-badge">Recommandé</div>
          <h3>Professionnel</h3>
          <div class="pricing-price">Sur devis <span>/projet</span></div>
          <div class="pricing-desc">Pour les PME en croissance numérique</div>
          <ul class="pricing-features">
            <li><span class="material-icons-round">check</span> Maintenance complète</li>
            <li><span class="material-icons-round">check</span> Site web + e-commerce</li>
            <li><span class="material-icons-round">check</span> Application mobile</li>
            <li><span class="material-icons-round">check</span> Identité visuelle complète</li>
            <li><span class="material-icons-round">check</span> Marketing digital (3 mois)</li>
          </ul>
          <a href="contact.html" class="btn btn-primary">Demander un devis</a>
        </div>
        <div class="pricing-card fade-in">
          <h3>Entreprise</h3>
          <div class="pricing-price">Sur devis <span>/an</span></div>
          <div class="pricing-desc">Solution complète pour grandes entreprises</div>
          <ul class="pricing-features">
            <li><span class="material-icons-round">check</span> Contrat de maintenance annuel</li>
            <li><span class="material-icons-round">check</span> Infrastructure réseau complète</li>
            <li><span class="material-icons-round">check</span> Logiciel de gestion sur mesure</li>
            <li><span class="material-icons-round">check</span> Marketing digital continu</li>
            <li><span class="material-icons-round">check</span> Support prioritaire 24/7</li>
          </ul>
          <a href="contact.html" class="btn btn-outline-dark">Nous contacter</a>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-section">
    <div class="container cta-inner">
      <div>
        <h2>Pas sûr du service qu'il vous faut ?</h2>
        <p>Contactez-nous, nous analyserons vos besoins et vous conseillerons gratuitement.</p>
      </div>
      <a href="contact.php" class="btn btn-primary">
        Consultation gratuite <span class="material-icons-round" style="font-size:18px">arrow_forward</span>
      </a>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>
  <script src="components.js"></script>
  <script>initComponents('services');</script>
</body>
</html>
