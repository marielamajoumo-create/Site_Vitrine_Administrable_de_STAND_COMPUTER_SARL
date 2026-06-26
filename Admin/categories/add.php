<?php
require_once __DIR__ . '/../../config/db.php';

if (isset($_POST['submit'])) {

    $nom = trim($_POST['nom']);

    if (!empty($nom)) {

        // check doublon
        $check = $pdo->prepare("SELECT id FROM categories WHERE nom = ?");
        $check->execute([$nom]);

        if (!$check->fetch()) {

            $insert = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
            $insert->execute([$nom]);

            header("Location: /StandComputer/gerer-les-categories");
            exit();
        } else {
            $error = "Catégorie déjà existante";
        }
    } else {
        $error = "Champ vide";
    }
}
?>

<link rel="stylesheet" href="/StandComputer/style-admin">

<h1>Ajouter une catégorie</h1>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="nom" placeholder="Nom catégorie">
    <button type="submit" name="submit">Ajouter</button>
</form>

<a href="/StandComputer/gerer-les-categories">Retour</a>