<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Toujours renvoyer du JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Récupération et validation des données
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $service = $_POST['service'] ?? '';
        $sujet = $_POST['sujet'] ?? '';
        $message = $_POST['message'] ?? '';

        // Validation: le sujet ne doit pas être vide
        if (empty($sujet)) {
            echo json_encode(["status" => "error", "message" => "Le sujet est obligatoire ❌"]);
            exit;
        }

        // Insertion dans la base de données
        $stmt = $pdo->prepare("
            INSERT INTO messages 
            (nom, email, telephone, serviceC, sujet, messageR, date_creation, statut) 
            VALUES (:nom, :email, :telephone, :serviceC, :sujet, :messageR, NOW(), 'non-lu')
        ");

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':serviceC', $service);
        $stmt->bindParam(':sujet', $sujet);
        $stmt->bindParam(':messageR', $message);

        if (!$stmt->execute()) {
            echo json_encode(["status" => "error", "message" => "Erreur lors de l'enregistrement ❌"]);
            exit;
        }

        // Récupération des emails destinataires depuis la table contacts
        $stmt_contacts = $pdo->prepare("SELECT email FROM contacts");
        $stmt_contacts->execute();
        $contacts = $stmt_contacts->fetchAll(PDO::FETCH_ASSOC);

        if (empty($contacts)) {
            echo json_encode(["status" => "error", "message" => "Aucun destinataire trouvé ❌"]);
            exit;
        }

        // Envoi des emails
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'marielamajoumo@gmail.com';
        $mail->Password = 'excx ioxw aqlu pxpl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('marielamajoumo@gmail.com', 'Stand Computer SARL');
        $mail->Subject = 'Nouveau message: ' . $sujet;
        
        // Corps du message avec tous les détails
        $mail->Body = "
Nouveau message du formulaire de contact:\n\n
Nom: $nom\n
Email: $email\n
Téléphone: $telephone\n
Service: $service\n
Sujet: $sujet\n\n
Message:\n$message
        ";

        // Ajouter tous les destinataires
        foreach ($contacts as $contact) {
            $mail->addAddress($contact['email']);
        }

        $mail->send();

        echo json_encode(["status" => "success", "message" => "Message enregistré avec succès et emails envoyés ✅"]);

    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Erreur lors de l'envoi: " . $e->getMessage() . " ❌"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Erreur base de données ❌: " . $e->getMessage()]);
    }
}
?>
