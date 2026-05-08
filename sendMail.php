<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';   // Autoload de Composer
require 'config/db.php';         // Ton fichier de connexion PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Récupérer les emails destinataires depuis la base
    $stmt = $pdo->query("SELECT email FROM contact");
    $destinataires = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $mail = new PHPMailer(true);

    try {
        // Config SMTP (exemple Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'marielamajoumo@gmail.com';
        $mail->Password = '65669704262'; // mot de passe d’application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Expéditeur
        $mail->setFrom($email, $nom);

        // Ajouter tous les destinataires depuis la BD
        foreach ($destinataires as $dest) {
            $mail->addAddress($dest);
        }

        // Contenu
        $mail->isHTML(false);
        $mail->Subject = "Nouveau message de contact";
        $mail->Body = "Nom: $nom\nEmail: $email\nMessage:\n$message";

        $mail->send();
        echo "Message envoyé avec succès ✅";
    } catch (Exception $e) {
        echo "Erreur lors de l’envoi ❌ : {$mail->ErrorInfo}";
    }
}
?>
