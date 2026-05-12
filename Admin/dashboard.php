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

