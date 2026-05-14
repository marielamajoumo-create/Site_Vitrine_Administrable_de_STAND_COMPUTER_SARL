<?php
session_start();
include '../config/db.php';

/* =========================
   SÉCURITÉ SESSION ADMIN
========================= */
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

/* =========================
   STATISTIQUES DASHBOARD
========================= */
$totalServices = $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
$totalFormations = $pdo->query("SELECT COUNT(*) FROM formations")->fetchColumn();
$totalRealisations = $pdo->query("SELECT COUNT(*) FROM realisations")->fetchColumn();
$totalImages = $pdo->query("SELECT COUNT(*) FROM realisation_images")->fetchColumn();
$totalMessages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();

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
    <link rel="stylesheet" href="../assets/css/style1.css">

<style>
/* ========================================
   STYLES DASHBOARD - À AJOUTER À LA FIN
   ======================================== */

/* Admin container */
.admin-container {
    display: flex;
    min-height: 100vh;
    background: #f8f9fc;
}

/* Sidebar */
.sidebar {
    width: 280px;
    background: linear-gradient(180deg, #0a1628 0%, #0f1e38 100%);
    color: white;
    padding: 30px 20px;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.sidebar h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #FF6B00;
    display: inline-block;
    color: white;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: rgba(255,255,255,0.8);
    padding: 12px 16px;
    margin: 6px 0;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.sidebar a:hover {
    background: rgba(255, 106, 0, 0.72);
    color: white;
    transform: translateX(5px);
}

/* Admin content */
.admin-content {
    flex: 1;
    padding: 30px 35px;
    background: #f8f9fc;
}

.admin-content h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #0a1628;
    margin-bottom: 8px;
}

.admin-content h2 {
    font-size: 1.3rem;
    font-weight: 600;
    color: #0a1628;
    margin: 25px 0 20px 0;
    position: relative;
    display: inline-block;
}

.admin-content h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: #FF6B00;
    border-radius: 3px;
}

/* Cartes statistiques dashboard */
.admin-content .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
    margin: 20px 0;
}

.admin-content .card {
    background: white;
    padding: 28px 20px;
    border-radius: 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    text-align: center;
    border: 1px solid #e9ecef;
    position: relative;
    overflow: hidden;
}

.admin-content .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #1565C0, #FF6B00);
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.admin-content .card:hover::before {
    transform: scaleX(1);
}

.admin-content .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.admin-content .card h3 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1565C0;
    margin-bottom: 8px;
}

.admin-content .card p {
    font-size: 0.85rem;
    font-weight: 500;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Tableau */
.admin-content table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.admin-content table th {
    background: linear-gradient(135deg, #0a1628 0%, #1565C0 100%);
    color: white;
    padding: 15px 18px;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
}

.admin-content table td {
    padding: 14px 18px;
    border-bottom: 1px solid #e9ecef;
    color: #1a2a3a;
}

.admin-content table tr:hover {
    background: rgba(21,101,192,0.03);
}

/* Boutons actions rapides */
.admin-content .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 22px;
    background: linear-gradient(135deg, #1565C0 0%, #0a1628 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.admin-content .btn:hover {
    background: linear-gradient(135deg, #FF6B00 0%, #e05a00 100%);
    transform: translateY(-2px);
}

.admin-content .grid .btn {
    background: white;
    color: #1565C0;
    border: 1.5px solid #1565C0;
}

.admin-content .grid .btn:hover {
    background: #1565C0;
    color: white;
}

/* Responsive */
@media (max-width: 992px) {
    .admin-container {
        flex-direction: column;
    }
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }
    .sidebar a {
        display: inline-flex;
        margin: 5px 8px;
    }
    .admin-content {
        padding: 25px 20px;
    }
}

@media (max-width: 768px) {
    .admin-content .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .admin-content .grid {
        grid-template-columns: 1fr;
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
        <h2>STAND ADMIN</h2>

        <a href="dashboard.php">Dashboard</a>

        <a href="services/add.php">Ajouter Service</a>
        <a href="services/manage.php">Gérer Services</a>

        <a href="formations/add.php">Ajouter Formation</a>
        <a href="formations/manage.php">Gérer Formations</a>

        <a href="realisations/add.php">Ajouter Réalisation</a>
        <a href="realisations/manage.php">Gérer Réalisations</a>

        <a href="statistiques/edit.php">Modifier Statistiques</a>


        <a href="formulaire_contact/manage.php">Gérer Messages Formulaires contact </a>

        <a href="logout.php">Déconnexion</a>
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
                <h3><?php echo $totalImages; ?></h3>
                <p>Images Portfolio</p>
            </div>
            <div class="card">
                <h3><?php echo $totalMessages; ?></h3>
                <p>Messages Formulaire Contact</p>
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
                <a href="formulaire_contact/manage.php" class="btn">+ Gérer Messages Contact</a>
                <a href="services/add.php" class="btn">+ Nouveau Service</a>
                <a href="formations/add.php" class="btn">+ Nouvelle Formation</a>
                <a href="realisations/add.php" class="btn">+ Nouvelle Réalisation</a>
                <a href="statistiques/edit.php" class="btn">⚙ Modifier Stats</a>
            </div>
        </section>

    </main>

</div>

</body>
</html>

