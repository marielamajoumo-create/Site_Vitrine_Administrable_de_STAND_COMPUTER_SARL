<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID manquant");
}

// récupérer catégorie
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();

if (!$cat) {
    die("Catégorie introuvable");
}

if (isset($_POST['update'])) {

    $nom = trim($_POST['nom']);

    if (!empty($nom)) {

        $update = $pdo->prepare("UPDATE categories SET nom = ? WHERE id = ?");
        $update->execute([$nom, $id]);

        header("Location: /StandComputer/gerer-les-categories");
        exit();
    } else {
        $error = "Champ vide";
    }
}
?>
<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Modifier catégorie</h1>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="nom" value="<?= htmlspecialchars($cat['nom']) ?>">
    <button type="submit" name="update">Modifier</button>
</form>
<br/>
<a href="/StandComputer/gerer-les-categories" class="back">Retour au tableau de gestion</a><br/> 
<br>
            <br>
<a href="/StandComputer/tableau-de-bord" class="back">Retour au tableau de bord 
            </a>
            
