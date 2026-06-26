<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$base = '/StandComputer/';

/* =========================
   SÉCURITÉ SESSION ADMIN
========================= */
if (!isset($_SESSION['admin'])) {
    header("Location: /StandComputer/connexion");
    exit();
}
$adminNom = $_SESSION['admin'];
$adminRole = $_SESSION['admin_role'] ?? 'admin';
$adminId = $_SESSION['admin_id'] ?? 0;


/* =========================
   STATISTIQUES DASHBOARD
========================= */
$totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$totalFormations = $pdo->query("SELECT COUNT(*) FROM formations")->fetchColumn();
$totalRealisations = $pdo->query("SELECT COUNT(*) FROM realisations")->fetchColumn();
$totalImages = $pdo->query("SELECT COUNT(*) FROM realisation_images")->fetchColumn();
$totalVideos = $pdo->query("SELECT COUNT(*) FROM realisation_videos")->fetchColumn();
$totalMessages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$totalContacts = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$totalHoraires = $pdo->query("SELECT COUNT(*) FROM horaires")->fetchColumn();
$totalarticles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$totalcategoriesarticles = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();


/* =========================
   DERNIÈRES RÉALISATIONS
========================= */
$latestRealisations = $pdo->query("
    SELECT * FROM realisations 
    ORDER BY created_at DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - STAND COMPUTER</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"><link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    

<style>
/* ========================================
   STYLES DASHBOARD - À AJOUTER À LA FIN
   ======================================== */

/* Admin container */
/* ==========================================
   DASHBOARD ADMIN
   Même univers visuel que la page login
   Sidebar sombre + contenu clair
========================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.sidebar a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    text-decoration: none;
}

.material-symbols-outlined {
    font-size: 22px;
}

body {
    font-family: 'Poppins', Arial, sans-serif;
    background: #f4f7fb;
    min-height: 100vh;
    color: #1e293b;
    position: relative;
}

/* Motif discret */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image:
        radial-gradient(circle, rgba(21, 101, 192, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 0;
}

.admin-container {
    position: relative;
    z-index: 1;
    display: flex;
    min-height: 100vh;
}

/* ==========================================
   SIDEBAR (bleu foncé comme le login)
========================================== */
.sidebar {
    width: 280px;
    background: linear-gradient(180deg, #0a1628 0%, #0f1a2e 100%);
    color: #ffffff;
    padding: 30px 20px;
    box-shadow: 8px 0 30px rgba(0, 0, 0, 0.25);
    overflow-y: auto;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 1.4rem;
    font-weight: 700;
    letter-spacing: 1px;
    color: #ffffff;
}

.sidebar a {
    display: block;
    padding: 12px 16px;
    margin-bottom: 8px;
    border-radius: 12px;
    color: rgba(255, 255, 255, 0.75);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.sidebar a:hover {
    background: rgba(255, 107, 0, 0.15);
    color: #ffffff;
    transform: translateX(4px);
}

/* Bouton déconnexion */
.sidebar a:last-child {
    margin-top: 20px;
    background: rgba(255, 255, 255, 0.08);
    color: #ffb38a;
}

.sidebar a:last-child:hover {
    background: rgba(255, 107, 0, 0.18);
    color: #ffffff;
}

/* ==========================================
   CONTENU PRINCIPAL (fond clair)
========================================== */
.admin-content {
    flex: 1;
    padding: 40px;
    background: transparent;
}

.admin-content h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #0f1a2e;
    margin-bottom: 6px;
}

.admin-content > p {
    font-size: 0.95rem;
    color: #64748b;
    margin-bottom: 35px;
}

/* ==========================================
   SECTIONS
========================================== */
section {
    margin-top: 40px;
}

section h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 20px;
}

/* ==========================================
   GRID
========================================== */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

/* ==========================================
   CARTES STATISTIQUES
========================================== */
.card {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
    border-color: rgba(255, 107, 0, 0.3);
}

.card h3 {
    font-size: 2.3rem;
    font-weight: 700;
    color: #1565C0;
    margin-bottom: 8px;
}

.card p {
    color: #64748b;
    font-size: 0.9rem;
}

/* ==========================================
   TABLEAU
========================================== */
table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
}

thead {
    background: #f8fafc;
}

th {
    padding: 16px 20px;
    text-align: left;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #1565C0;
    font-weight: 600;
}

td {
    padding: 16px 20px;
    font-size: 0.9rem;
    color: #334155;
    border-top: 1px solid #f1f5f9;
}

tbody tr:hover {
    background: #f8fafc;
}

/* ==========================================
   BOUTONS
========================================== */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    color: #ffffff;
    background: linear-gradient(135deg, #FF6B00, #e55a00);
    box-shadow: 0 10px 20px rgba(255, 107, 0, 0.2);
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 28px rgba(255, 107, 0, 0.28);
}

/* ==========================================
   RESPONSIVE
========================================== */
@media (max-width: 992px) {
    .admin-container {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
    }

    .admin-content {
        padding: 25px;
    }
}

@media (max-width: 768px) {
    .grid {
        grid-template-columns: 1fr;
    }

    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .admin-content h1 {
        font-size: 1.6rem;
    }
}

@media (max-width: 480px) {
    .admin-content {
        padding: 20px 15px;
    }

    .sidebar {
        padding: 20px 15px;
    }

    .card {
        padding: 22px 18px;
    }

    .card h3 {
        font-size: 1.9rem;
    }
}
</style>

</head>

<body>

<div class="admin-container">

    <!-- =========================
         SIDEBAR ADMIN
    ========================== -->
    <aside class="sidebar">
    <h2>
        <span class="material-symbols-outlined" style="color:#FFB300;">admin_panel_settings</span>
        STAND ADMIN
    </h2>

    <a href="<?= $base ?>tableau-de-bord">
        <span class="material-symbols-outlined" style="color:#FFC107;">dashboard</span>
        Dashboard
    </a>

    <?php if($adminRole === 'super_admin'): ?>

       <a href="<?= $base ?>gerer-les-administrateurs">
           <span class="material-symbols-outlined" style="color:#FFC107;">manage_accounts</span>
           Gestion Administrateurs
       </a>

    <?php endif; ?>

    <a href="<?= $base ?>ajouter-un-service">
        <span class="material-symbols-outlined" style="color:#FF6F00;">add_circle</span>
        Ajouter Service
    </a>

    <a href="<?= $base ?>gerer-les-services">
        <span class="material-symbols-outlined" style="color:#FFA726;">construction</span>
        Gérer Services
    </a>

    <a href="<?= $base ?>ajouter-une-formation">
        <span class="material-symbols-outlined" style="color:#FFD54F;">school</span>
        Ajouter Formation
    </a>

    <a href="<?= $base ?>gerer-les-formations">
        <span class="material-symbols-outlined" style="color:#FFCA28;">menu_book</span>
        Gérer Formations
    </a>

    <a href="<?= $base ?>ajouter-une-realisation">
        <span class="material-symbols-outlined" style="color:#FF7043;">add_photo_alternate</span>
        Ajouter Réalisation
    </a>

    <a href="<?= $base ?>gerer-les-realisations">
        <span class="material-symbols-outlined" style="color:#FF5722;">work</span>
        Gérer Réalisations
    </a>

    <a href="<?= $base ?>ajouter-un-contact">
        <span class="material-symbols-outlined" style="color:#26C6DA;">person_add</span>
        Ajouter Contact
    </a>

    <a href="<?= $base ?>gerer-les-contacts">
        <span class="material-symbols-outlined" style="color:#00ACC1;">contacts</span>
        Gérer Contacts
    </a>

    <a href="<?= $base ?>ajouter-une-horaire">
        <span class="material-symbols-outlined" style="color:#66BB6A;">schedule</span>
        Ajouter Horaire
    </a>

    <a href="<?= $base ?>gerer-les-horaires">
        <span class="material-symbols-outlined" style="color:#43A047;">calendar_month</span>
        Gérer Horaires
    </a>

    <a href="<?= $base ?>ajouter-un-article">
        <span class="material-symbols-outlined" style="color:#EC407A;">post_add</span>
        Ajouter Article
    </a>

    <a href="<?= $base ?>gerer-les-articles">
        <span class="material-symbols-outlined" style="color:#D81B60;">article</span>
        Gérer Articles
    </a>

    <a href="<?= $base ?>ajouter-une-categorie">
        <span class="material-symbols-outlined" style="color:#AB47BC;">category</span>
        Ajouter Catégorie Article
    </a>

    <a href="<?= $base ?>gerer-les-categories">
        <span class="material-symbols-outlined" style="color:#8E24AA;">folder</span>
        Gérer Catégories Articles
    </a>

    <a href="<?= $base ?>gerer-les-formulaires-de-contact">
        <span class="material-symbols-outlined" style="color:#EF5350;">mail</span>
        Messages de Contact
    </a>

    <a href="<?= $base ?>modifier-les-statistiques">
        <span class="material-symbols-outlined" style="color:#FF8F00;">bar_chart</span>
        Modifier Statistiques
    </a>

    <a href="<?= $base ?>deconnexion">
        <span class="material-symbols-outlined" style="color:#B0BEC5;">logout</span>
        Déconnexion
    </a>
</aside>

    <!-- =========================
         CONTENU PRINCIPAL
    ========================== -->
    <main class="admin-content">

        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin']); ?></h1>
        <p>Tableau de bord de gestion STAND COMPUTER</p>

        <!-- =========================
             CARTES STATISTIQUES
        ========================== -->
        <section class="grid">

            <div class="card">
                <h3><?php echo $totalServices; ?></h3>
                <p>Services</p>
            </div>

            <div class="card">
                <h3><?php echo $totalFormations; ?></h3>
                <p>Formations</p>
            </div>

            <div class="card">
                <h3><?php echo $totalRealisations; ?></h3>
                <p>Réalisations</p>
            </div>
            
             <div class="card">
                <h3><?php echo $totalarticles; ?></h3>
                <p>Articles de blog</p>
             </div>

             <div class="card">
                <h3><?php echo $totalcategoriesarticles; ?></h3>
                <p>Categorie des Articles de blog</p>
             </div>

            <div class="card">
                <h3><?php echo $totalImages; ?></h3>
                <p>Images Portfolio</p>
            </div>

            
            <div class="card">
                <h3><?php echo $totalVideos; ?></h3>
                <p>Videos Portfolio</p>
            </div>


            <div class="card">
                <h3><?php echo $totalMessages; ?></h3>
                <p>Messages Formulaire Contact</p>
            </div>

            <div class="card">
                <h3><?php echo $totalContacts; ?></h3>
                <p>Contacts</p>
            </div>

            <div class="card">
                <h3><?php echo $totalHoraires; ?></h3>
                <p>Horaires</p>
            </div>
            

        </section>


        <!-- =========================
             TABLEAU DERNIÈRES RÉALISATIONS
        ========================== -->
        <section style="margin-top:40px;">
            <h2>Dernières Réalisations</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($latestRealisations as $real): ?>
                        <tr>
                            <td><?php echo $real['id']; ?></td>
                            <td><?php echo htmlspecialchars($real['title']); ?></td>
                            <td><?php echo htmlspecialchars($real['category']); ?></td>
                            <td><?php echo $real['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </section>


        <!-- =========================
             ACTIONS RAPIDES
        ========================== -->
        <section style="margin-top:40px;">
            <h2>Actions Rapides</h2>

            <div class="grid">
                <a href="/StandComputer/gerer-les-formulaires-de-contact" class="btn">+ Gérer Messages Contact</a>
                <a href="/StandComputer/ajouter-un-service" class="btn">+ Nouveau Service</a>
                <a href="/StandComputer/ajouter-une-formation" class="btn">+ Nouvelle Formation</a>
                <a href="/StandComputer/ajouter-une-realisation" class="btn">+ Nouvelle Réalisation</a>
                <a href="/StandComputer/modifier-les-statistiques" class="btn">⚙ Modifier Stats</a>
            </div>
        </section>

    </main>

</div>

</body>
</html>

