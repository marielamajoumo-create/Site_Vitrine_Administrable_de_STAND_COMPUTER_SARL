
async function getServices() {

  try {
    const response = await fetch('API/get_services.php');
    return await response.json();
  } catch (error) {
    console.error("Erreur lors du chargement des services :", error);
    return [];
  }
}
async function getContacts() {

  try {
    const response = await fetch ('API/get_contact.php');
    return await response.json();
  } catch (error) {
    console.error("Erreur lors du chargement des contacts :", error);
    return [];
  }
}

/* ═══════════════════════════════════════════════════
   STAND COMPUTER SARL — Composants partagés
   Navbar + Footer injectés dynamiquement
═══════════════════════════════════════════════════ */
async function buildNavbar(activeId) {
  const services = await getServices();
const NAV_LINKS = [
  { label: 'Accueil',      href: 'index.php',        id: 'accueil' },
  { label: 'À propos',     href: 'about.php',         id: 'about' },
  { label: 'Services',     href: 'services.php',      id: 'services', dropdown:services},
  { label: 'Formations',   href: 'formations.php',    id: 'formations' },
  { label: 'Réalisations', href: 'realisations.php',  id: 'realisations' },
  { label: 'Blog',         href: 'blog.php',           id: 'blog' },
  { label: 'Contact',      href: 'contact.php',        id: 'contact' },
];

  const linksHTML = NAV_LINKS.map(link => {
    const isActive = link.id === activeId ? 'active' : '';
    if (link.dropdown) {
      //const services=window.servicesData || [];
      const dropItems = link.dropdown.map(s =>
        `<a href="services.php#${s.slug}">${s.title}</a>`
      ).join('');
      return `
        <li class="has-dropdown">
          <a href="${link.href}" class="${isActive}">${link.label} ▾</a>
          <div class="dropdown">${dropItems}</div>
        </li>`;
    }
    return `<li><a href="${link.href}" class="${isActive}">${link.label}</a></li>`;
  }).join('');

  const mobileHTML = NAV_LINKS.map(link =>
    `<a href="${link.href}">${link.label}</a>`
  ).join('');

  return `
    <nav id="navbar">
      <div class="container nav-inner">
        <a href="index.php" class="nav-logo">
          <img src="logo.jpeg" alt="Stand Computer SARL" />
        </a>
        <ul class="nav-links">${linksHTML}</ul>
        <a href="contact.php" class="btn btn-primary nav-cta">Demander un devis</a>
        <div class="hamburger" id="hamburger" aria-label="Menu">
          <span></span><span></span><span></span>
        </div>
      </div>
    </nav>
    <div class="mobile-menu" id="mobileMenu">
      ${mobileHTML}
      <a href="contact.php" class="btn btn-primary">Demander un devis</a>
    </div>
    </nav>`;
}
async function loadFooterContact() {
  try {
    const contact = await getContacts ();
    console.log (contact);

    // Injection dynamique
    document.querySelector('.footer-contact-item.phone a').textContent = contact.phone;
    document.querySelector('.footer-contact-item.phone a').href = "tel:" + contact.phone;

    document.querySelector('.footer-contact-item.email a').textContent = contact.email;
    document.querySelector('.footer-contact-item.email a').href = "mailto:" + contact.email;

     const fullAddress= `${contact.localisation},${contact.villeQuartier},${contact.pays}`;
    document.querySelector('.footer-contact-item.address span').textContent = fullAddress;
  } catch (err) {
    console.error("Erreur chargement contact footer:", err);
  }
}



async function loadFooterServices() {

  try {
    const services = await getServices(); 
    const list=document.getElementById ('footer-services-list');
    if (!list) {
      console.error ("Footer non trouve dans le DOM ");
      return;
    }
    list.innerHTML = services.map(s =>
              `<li><a href="services.php#${s.slug}">${s.title}</a><li>`
    ).join('');
  } catch (err) {
    console.error ("Erreur chargement services footer :" , err)
  }
}
function buildFooter() {
      
  return `

    <footer id="footer">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-brand">
            <img src="logo.jpeg" alt="Stand Computer SARL" />
            <p>Votre partenaire de confiance pour toutes vos solutions technologiques et digitales.</p>
            <div class="footer-socials">
              <a href="#" class="social-icon" aria-label="Facebook">f</a>
              <a href="#" class="social-icon" aria-label="LinkedIn">in</a>
              <a href="#" class="social-icon" aria-label="Instagram">ig</a>
              <a href="https://wa.me/243979714281" class="social-icon" aria-label="WhatsApp">
                <span class="material-icons-round" style="font-size:16px">chat</span>
              </a>
              
            </div>
            
            <a href="admin/login.php" class="adminpath">admin</a>
          </div>
          <div class="footer-col">
            <h4>Liens rapides</h4>
            <ul>
              <li><a href="index.php">Accueil</a></li>
              <li><a href="about.php">À propos</a></li>
              <li><a href="services.php">Services</a></li>
              <li><a href="realisations.php">Réalisations</a></li>
              <li><a href="formations.php">Formations</a></li>
              <li><a href="blog.php">Blog</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Nos services</h4>
                

              <ul id="footer-services-list"></ul>
          </div>
          <div class="footer-col">
            <h4>Contact</h4>
            <div class="footer-contact-item phone">
              <span class="material-icons-round">phone</span>
              <a href="#"></a>
            </div>
            <div class="footer-contact-item email">
              <span class="material-icons-round">email</span>
              <a href="#"></a>
            </div>
            <div class="footer-contact-item address">
              <span class="material-icons-round">location_on</span>
              <span></span>
            </div>
            <a href="contact.php" class="btn btn-blue" style="margin-top:12px;padding:8px 18px;font-size:.8rem;">
              Nous écrire
            </a>
            <div style="margin-top:24px;">
              <h4>Newsletter</h4>
              <p style="font-size:.8rem;color:rgba(255,255,255,.5);margin-bottom:4px;">Abonnez-vous pour recevoir nos actualités.</p>
              <div class="newsletter-form">
                <input type="email" placeholder="Votre email" />
                <button type="button" id="newsletter-btn" aria-label="S'abonner">
                  <span class="material-icons-round" style="font-size:18px">send</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <span>© 2024 STAND COMPUTER. Tous droits réservés.</span>
          <div class="footer-bottom-links">
            <a href="#">Mentions légales</a>
            <a href="#">Politique de confidentialité</a>
          </div>
          <span class="footer-credit">Développé avec <span class="heart">♥</span> par STAND COMPUTER</span>
        </div>
      </div>
    </footer>`;
}



function buildFABs() {
  return `
    <a href="https://wa.me/$(contact.whatsapp)" class="whatsapp-fab" target="_blank" rel="noopener" aria-label="WhatsApp">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
    </a>
    <button id="back-top" aria-label="Retour en haut">
      <span class="material-icons-round">keyboard_arrow_up</span>
    </button>`;
}

async function initComponents(activeId) {
  //charger les services
         //window.servicesData=await getServices ();
  // Inject navbar
  const navPlaceholder = document.getElementById('nav-placeholder');
  if (navPlaceholder) navPlaceholder.innerHTML = await buildNavbar(activeId);

  // Inject footer
  const footerPlaceholder = document.getElementById('footer-placeholder');
  if (footerPlaceholder) footerPlaceholder.innerHTML = buildFooter();
  loadFooterServices();
  loadFooterContact ();

  // Inject FABs
  const fabPlaceholder = document.getElementById('fab-placeholder');
  if (fabPlaceholder) fabPlaceholder.innerHTML = buildFABs();

  // Navbar scroll shadow
  const navbar = document.getElementById('navbar');
 if (navbar){
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }); }

  // Hamburger menu
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('open');
      mobileMenu.classList.toggle('open');
    });
    mobileMenu.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        hamburger.classList.remove('open');
        mobileMenu.classList.remove('open');
      });
    });
  }

  // Back to top
  const backTop = document.getElementById('back-top');
  if (backTop) {
    window.addEventListener('scroll', () => {
      backTop.classList.toggle('visible', window.scrollY > 400);
    });
    backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  }

  // Newsletter
  const newsletterBtn = document.getElementById('newsletter-btn');
  if (newsletterBtn) {
    newsletterBtn.addEventListener('click', function () {
      const input = this.previousElementSibling;
      if (input.value && input.value.includes('@')) {
        input.value = '';
        input.placeholder = 'Merci pour votre inscription !';
        setTimeout(() => { input.placeholder = 'Votre email'; }, 3000);
      }
    });
  }

  // Fade-in animation
  setTimeout(() => {
    const fadeEls = document.querySelectorAll('.fade-in');
    const fadeObserver = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          fadeObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    fadeEls.forEach((el, i) => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(24px)';
      el.style.transition = `opacity .5s ease ${i * 0.07}s, transform .5s ease ${i * 0.07}s`;
      fadeObserver.observe(el);
    });
  }, 100);
}
