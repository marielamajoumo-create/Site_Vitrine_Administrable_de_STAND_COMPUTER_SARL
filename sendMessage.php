<?php

require_once __DIR__ . '/config/db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {

        /*
        |--------------------------------------------------------------------------
        | DONNEES
        |--------------------------------------------------------------------------
        */

        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $telephone = htmlspecialchars($_POST['telephone']);
        $service = htmlspecialchars($_POST['service']);
        $sujet = htmlspecialchars($_POST['sujet']);
        $message = htmlspecialchars($_POST['message']);

        /*
        |--------------------------------------------------------------------------
        | ENREGISTREMENT EN BASE
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->prepare("
            INSERT INTO messages
            (nom, email, telephone, serviceC, sujet, messageR, date_creation, statut)
            VALUES
            (:nom, :email, :telephone, :serviceC, :sujet, :messageR, NOW(), 'non-lu')
        ");

        $stmt->execute([
            ':nom' => $nom,
            ':email' => $email,
            ':telephone' => $telephone,
            ':serviceC' => $service,
            ':sujet' => $sujet,
            ':messageR' => $message
        ]);

        /*
        |--------------------------------------------------------------------------
        | RECUPERATION NUMERO WHATSAPP
        |--------------------------------------------------------------------------
        */

        $req = $pdo->query("SELECT whatsapp FROM contacts LIMIT 1");

        $data = $req->fetch();

        $numeroWhatsapp = $data['whatsapp'];

        /*
        |--------------------------------------------------------------------------
        | MESSAGE WHATSAPP
        |--------------------------------------------------------------------------
        */

        $texte = "Bonjour,\n\n";
        $texte .= "Nom : $nom \n";
        $texte .= "Email : $email \n";
        $texte .= "Téléphone : $telephone \n";
        $texte .= "Service : $service \n";
        $texte .= "Sujet : $sujet \n";
        $texte .= "Message : $message";

        $texteEncode = urlencode($texte);

        $whatsappUrl = "https://wa.me/$numeroWhatsapp?text=$texteEncode";

        /*
        |--------------------------------------------------------------------------
        | REPONSE JSON
        |--------------------------------------------------------------------------
        */

        echo json_encode([
            "status" => "success",
            "message" => "Message envoyé avec succès ✅",
            "redirect" => $whatsappUrl
        ]);

    } catch (PDOException $e) {

        echo json_encode([
            "status" => "error",
            "message" => "Erreur : " . $e->getMessage()
        ]);

    }

}
?>