<?php
require_once __DIR__ . '/../../config/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $msg = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<link rel="stylesheet" href="/StandComputer/style-admin">

<style>
/* ==========================================
   DÉTAIL D'UN MESSAGE
========================================== */

.message-card {
    max-width: 900px;
    margin: 40px auto;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 22px;
    padding: 35px 40px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
    position: relative;
    overflow: hidden;
}

/* Barre décorative en haut */
.message-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, #1565c0, #ff6b00);
}

/* Titre */
.message-card h2 {
    font-size: 1.9rem;
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;

    background: linear-gradient(135deg, #1565c0, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Lignes d'information */
.message-item {
    padding: 14px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.95rem;
    color: #334155;
    line-height: 1.7;
}

.message-item:last-child {
    border-bottom: none;
}

/* Libellé */
.message-item strong {
    display: inline-block;
    min-width: 120px;
    color: #0f172a;
    font-weight: 600;
}

/* Bloc du message */
.message-content {
    margin-top: 8px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #ff6b00;
    border-radius: 12px;
    padding: 18px;
    color: #475569;
    white-space: pre-line;
}

/* Statuts */
.status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status.nouveau {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
}

.status.lu {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
}

.status.traite {
    background: rgba(255, 107, 0, 0.12);
    color: #ea580c;
}

/* Message introuvable */
.message-not-found {
    max-width: 600px;
    margin: 60px auto;
    padding: 25px 30px;
    text-align: center;
    background: #fff1f2;
    border: 1px solid #fecdd3;
    border-radius: 16px;
    color: #be123c;
    font-weight: 600;
    box-shadow: 0 10px 25px rgba(190, 24, 93, 0.08);
}

/* Bouton retour */
.message-actions {
    margin-top: 30px;
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .message-card {
        margin: 20px;
        padding: 25px 20px;
    }

    .message-card h2 {
        font-size: 1.5rem;
    }

    .message-item strong {
        display: block;
        margin-bottom: 4px;
        min-width: auto;
    }
}
</style>

<?php if ($msg): ?>
<div class="message-card">

    <h2>Message <?= $msg['id'] ?></h2>

    <div class="message-item">
        <strong>Nom :</strong>
        <?= htmlspecialchars($msg['nom']) ?>
    </div>

    <div class="message-item">
        <strong>Email :</strong>
        <?= htmlspecialchars($msg['email']) ?>
    </div>

    <div class="message-item">
        <strong>Téléphone :</strong>
        <?= htmlspecialchars($msg['telephone']) ?>
    </div>

    <div class="message-item">
        <strong>Service :</strong>
        <?= htmlspecialchars($msg['serviceC']) ?>
    </div>

    <div class="message-item">
        <strong>Sujet :</strong>
        <?= htmlspecialchars($msg['sujet']) ?>
    </div>

    <div class="message-item">
        <strong>Message :</strong>
        <div class="message-content">
            <?= nl2br(htmlspecialchars($msg['messageR'])) ?>
        </div>
    </div>

    <div class="message-item">
        <strong>Date :</strong>
        <?= $msg['date_creation'] ?>
    </div>

    <div class="message-item">
        <strong>Statut :</strong>
        <span class="status <?= strtolower($msg['statut']) ?>">
            <?= htmlspecialchars($msg['statut']) ?>
        </span>
    </div>

    <div class="message-actions">
        <a href="/StandComputer/gerer-les-formulaires-de-contact" class="back">← Retour aux messages</a>
    </div>

</div>
<?php else: ?>
    <div class="message-not-found">
        Message introuvable ❌
    </div>
<?php endif; ?>