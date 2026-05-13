<?php
include 'config/db.php';


$horaires = $pdo->query("SELECT * FROM horaires ")->fetchAll(PDO::FETCH_ASSOC);
$services = $pdo->query("SELECT * FROM services ")->fetchAll(PDO::FETCH_ASSOC);
$contacts = $pdo->query("SELECT * FROM contacts")->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact – Stand Computer SARL</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/shared.css" />
  <style>
    body { padding-top: var(--nav-h); }

    /* ─── Contact Layout ── */
    .contact-section { padding: 80px 0; }
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1.4fr;
      gap: 64px;
      align-items: start;
    }

    /* Info column */
    .contact-info h2 { font-size: 1.6rem; font-weight: 700; margin-bottom: 8px; }
    .contact-info h2 .accent { color: var(--accent); }
    .contact-info > p { color: var(--text-muted); font-size: .9rem; line-height: 1.7; margin-bottom: 32px; }
    .info-item {
      display: flex;
      gap: 16px;
      align-items: flex-start;
      margin-bottom: 24px;
    }
    .info-icon {
      width: 48px; height: 48px;
      border-radius: var(--radius-md);
      background: var(--bg-light);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .info-icon .material-icons-round { color: var(--primary); font-size: 22px; }
    .info-item h4 { font-size: .9rem; font-weight: 700; margin-bottom: 4px; }
    .info-item p, .info-item a { font-size: .87rem; color: var(--text-muted); line-height: 1.6; }
    .info-item a:hover { color: var(--accent); }

    .hours-grid {
      background: var(--bg-light);
      border-radius: var(--radius-md);
      padding: 20px;
      margin-top: 24px;
    }
    .hours-grid h4 { font-size: .9rem; font-weight: 700; margin-bottom: 12px; }
    .hours-row {
      display: flex;
      justify-content: space-between;
      font-size: .85rem;
      padding: 6px 0;
      border-bottom: 1px solid var(--border);
      color: var(--text-muted);
    }
    .hours-row:last-child { border: none; }
    .hours-row .open { color: #2E7D32; font-weight: 600; }
    .hours-row .closed { color: #C62828; font-weight: 600; }

    /* Form column */
    .contact-form-wrap {
      background: var(--surface);
      border-radius: var(--radius-lg);
      padding: 40px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow-md);
    }
    .contact-form-wrap h2 { font-size: 1.3rem; font-weight: 700; margin-bottom: 6px; }
    .contact-form-wrap > p { font-size: .87rem; color: var(--text-muted); margin-bottom: 28px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { margin-bottom: 20px; }
    .form-group label {
      display: block;
      font-size: .85rem;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 6px;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 12px 16px;
      border-radius: var(--radius-md);
      border: 1.5px solid var(--border);
      font-family: inherit;
      font-size: .9rem;
      color: var(--text-main);
      background: var(--surface);
      outline: none;
      transition: var(--transition);
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(21,101,192,.1);
    }
    .form-group textarea { resize: vertical; min-height: 130px; }
    .form-group select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236B7280' stroke-width='1.5' fill='none'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; }
    .form-submit { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .form-note { font-size: .78rem; color: var(--text-muted); }
    .form-success {
      display: none;
      background: #E8F5E9;
      border: 1px solid #A5D6A7;
      border-radius: var(--radius-md);
      padding: 16px 20px;
      color: #2E7D32;
      font-size: .9rem;
      margin-top: 16px;
      align-items: center;
      gap: 10px;
    }

    /* Map placeholder */
    .map-section { padding: 0 0 80px; }
    .map-wrap {
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-md);
      background: var(--bg-light);
      height: 380px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid var(--border);
      position: relative;
    }
    .map-wrap iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
    .map-pin {
      position: absolute;
      background: var(--primary);
      color: #fff;
      padding: 12px 20px;
      border-radius: var(--radius-pill);
      font-size: .85rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: var(--shadow-md);
    }

    /* Social contact */
    .social-contact-section { padding: 0 0 80px; }
    .social-cards {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }
    .social-card {
      border-radius: var(--radius-lg);
      padding: 28px 20px;
      text-align: center;
      border: 1px solid var(--border);
      transition: var(--transition);
      cursor: pointer;
    }
    .social-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
    .social-card .s-icon {
      width: 56px; height: 56px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 14px;
      font-size: 1.1rem;
      font-weight: 700;
      color: #fff;
    }
    .fb { background: #1877F2; }
    .li { background: #0A66C2; }
    .ig { background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .wa { background: #25D366; }
    .social-card h3 { font-size: .9rem; font-weight: 700; margin-bottom: 4px; }
    .social-card p { font-size: .78rem; color: var(--text-muted); }

    @media (max-width: 900px) {
      .contact-grid { grid-template-columns: 1fr; }
      .social-cards { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
      .form-row { grid-template-columns: 1fr; }
      .contact-form-wrap { padding: 24px; }
      .social-cards { grid-template-columns: repeat(2, 1fr); }
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
        <span class="current">Contact</span>
      </div>
      <h1>Nous <span class="accent">Contacter</span></h1>
      <p>Notre équipe est disponible du lundi au samedi pour répondre à toutes vos questions et demandes de devis.</p>
    </div>
  </section>

  <!-- Contact form + infos -->
  <section class="contact-section">
    <div class="container">
      <div class="contact-grid">

        <!-- Infos -->
        <div class="contact-info fade-in">
          <h2>Restons en <span class="accent">contact</span></h2>
          <p>Que vous ayez un projet, une question ou besoin d'assistance, notre équipe est à votre écoute. N'hésitez pas à nous joindre par le moyen qui vous convient.</p>

          <div class="info-item">
            <div class="info-icon"><span class="material-icons-round">phone</span></div>
            <div>
              <h4>Téléphone</h4>
              <?php foreach ($contacts as $contact) : ?>
                <p><a href="tel:<?php echo $contact['phone']; ?>"><?php echo $contact['phone']; ?></a></p>
              <?php endforeach ?>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon"><span class="material-icons-round">email</span></div>
            <div>
              <h4>Email</h4>
              <?php foreach ($contacts as $contact) : ?>
              <p><a href="<?php echo $contact['email']; ?>"><?php echo $contact['email']; ?></a></p>
              <?php endforeach ?>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon"><span class="material-icons-round">location_on</span></div>
            <div>
              <h4>Adresse</h4>
              <?php foreach ($contacts as $contact) : ?>
                 <p><?php echo $contact['localisation']; ?><br /><?php echo $contact['villeQuartier']; ?><br /><?php echo $contact['pays']; ?></p>
              <?php endforeach ?>
            </div>
          </div>

          <div class="info-item">
            <div class="info-icon"><span class="material-icons-round">chat</span></div>
            <div>
              <h4>WhatsApp</h4>
                <?php foreach ($contacts as $contact) : ?>
              <p><a href="https://wa.me/<?php echo $contact['whatsapp']; ?>" target="_blank">Chattez avec nous sur WhatsApp</a></p>
                <?php endforeach ?>   
            </div>
          </div>

          <div class="hours-grid">
            <h4>Heures d'ouverture</h4>
              <?php foreach ($horaires as $horaire) : ?>
                <div class="hours-row"><span> <?php echo $horaire['jour']; ?></span><span class="open"><?php echo $horaire['ouvertureFermeture']; ?></span></div>
             <?php endforeach ?>
              <?php foreach ($horaires as $horaire) : ?>
                  <?php if ($horaire['ouvertureFermeture']=== 'ferme') : ?>
                      <div class="hours-row"><span> <?php echo $horaire['jour']; ?></span><span class="closed">Fermé</span></div>
                  <?php endif ?>
              <?php endforeach ?>
          </div>
        </div>

        <!-- Formulaire -->
        <div class="contact-form-wrap fade-in">
          <h2>Envoyez-nous un message</h2>
          <p>Remplissez le formulaire ci-dessous et nous vous répondrons dans les 24 heures.</p>
          <form id="contactForm" novalidate>
            <div class="form-row">
              <div class="form-group">
                <label for="nom">Nom complet *</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" required />
              </div>
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" placeholder="votre@email.com" required />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" placeholder="+237 XXX XXX XXX" />
              </div>
              <div class="form-group">
                <label for="service">Service souhaité</label>
                <select id="service" name="service">

                  <option value="">-- Choisir un service --</option>                   
                  <?php foreach ($services as $service) : ?>
                    <option><?php echo $service['title']; ?></option>
                  <?php endforeach ?>
                  <option>Autre</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="sujet">Sujet *</label>
              <input type="text" id="sujet" name="sujet" placeholder="Objet de votre message" required />
            </div>
            <div class="form-group">
              <label for="message">Message *</label>
              <textarea id="message" name="message" placeholder="Décrivez votre projet ou votre besoin..." required></textarea>
            </div>
            <div class="form-submit">
              <span class="form-note">* Champs obligatoires</span>
              <button type="submit" class="btn btn-primary">
                Envoyer le message
                <span class="material-icons-round" style="font-size:18px">send</span>
              </button>
            </div>
            <div class="form-success" id="formSuccess">
              <span class="material-icons-round">check_circle</span>
              Votre message a bien été envoyé ! Nous vous répondrons sous 24h.
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>

  <!-- Carte -->
  <section class="map-section">
    <div class="container">
      <div class="map-wrap">
        <div class="map-pin">                         
          <?php foreach ($contacts as $contact) : ?>
          <span class="material-icons-round">location_on</span>
              <?php echo $contact['localisation']; ?>, <?php echo $contact['villeQuartier']; ?>, <?php echo $contact['pays']; ?></p>
          <?php endforeach ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Réseaux sociaux -->
  <section class="social-contact-section">
    <div class="container">
      <div style="text-align:center;margin-bottom:36px;">
        <span class="section-label">Nos réseaux sociaux</span>
        <h2 class="section-title">Suivez-nous sur les <span class="accent">réseaux</span></h2>
      </div>
      <div class="social-cards">
        <a href="#" class="social-card fade-in">
          <div class="s-icon fb">f</div>
          <h3>Facebook</h3>
          <p>@StandComputerSARL</p>
        </a>
        <a href="#" class="social-card fade-in">
          <div class="s-icon li">in</div>
          <h3>LinkedIn</h3>
          <p>Stand Computer SARL</p>
        </a>
        <a href="#" class="social-card fade-in">
          <div class="s-icon ig">ig</div>
          <h3>Instagram</h3>
          <p>@standcomputer</p>
        </a>
        <?php foreach ($contacts as $contact) : ?>
         <a href="https://wa.me/<?php echo $contact['whatsapp']; ?>" class="social-card fade-in" target="_blank">
          <div class="s-icon wa">
            <span class="material-icons-round" style="font-size:22px">chat</span>
          </div>
          <h3>WhatsApp</h3>
          <p><?php echo $contact['whatsapp']; ?> </p>
         </a>               
        <?php endforeach ?> 

      </div>
    </div>
  </section>

  <div id="footer-placeholder"></div>
  <div id="fab-placeholder"></div>
  <script src="components.js"></script>
  <script>
    initComponents ('contact');
       document.getElementById('contactForm').addEventListener('submit', (e) => {
  e.preventDefault();

  const form = e.target; // on récupère directement le formulaire
  const nom = form.nom.value.trim();
  const email = form.email.value.trim();
  const telephone = form.telephone.value.trim();
  const service = form.service.value.trim();
  const sujet = form.sujet.value.trim();
  const message = form.message.value.trim();

  fetch('sendMessage.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `nom=${encodeURIComponent(nom)}&email=${encodeURIComponent(email)}&telephone=${encodeURIComponent(telephone)}&service=${encodeURIComponent(service)}&sujet=${encodeURIComponent(sujet)}&message=${encodeURIComponent(message)}`
  })
  .then(response => response.json())
  .then(data => {
    const success = document.getElementById('formSuccess');
    success.style.display = 'flex';
    success.textContent = data.message;
    form.reset(); // reset propre du formulaire
    setTimeout(() => { success.style.display = 'none'; }, 6000);
  })
  .catch(error => {
    alert('Erreur lors de l’envoi : ' + error);
  });
});
</script>
</body>
</html>