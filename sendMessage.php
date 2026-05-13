<?php
     //Connexion PDO centralisée
 require_once __DIR__ . '/config/db.php'; 

 // Toujours renvoyer du JSON
 header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Préparer la requête
        $stmt = $pdo->prepare("
            INSERT INTO messages 
            (nom, email, telephone, serviceC, sujet, messageR, date_creation, statut) 
            VALUES (:nom, :email, :telephone, :serviceC, :sujet, :messageR, NOW(), 'non-lu')
        ");

        // Liaison des paramètres
        $stmt->bindParam(':nom', $_POST['nom']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':telephone', $_POST['telephone']);
        $stmt->bindParam(':serviceC', $_POST['service']);
        $stmt->bindParam(':sujet', $_POST['sujet']);
        $stmt->bindParam(':messageR', $_POST['message']);

        // Exécution
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Message enregistré avec succès ✅"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erreur lors de l’enregistrement ❌"]);
        }

    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur PDO ❌ : " . $e->getMessage()]);
    }
}
?>  
