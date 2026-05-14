<?php
include '../config/db.php';

// Récupérer tous les messages de contact
$query = "SELECT * FROM messages_contact ORDER BY date_creation DESC";
$stmt = $pdo->query($query);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gérer le changement de statut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status' && isset($_POST['id']) && isset($_POST['statut'])) {
        $update_query = "UPDATE messages_contact SET statut = :statut WHERE id = :id";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([
            ':statut' => $_POST['statut'],
            ':id' => $_POST['id']
        ]);
        header('Location: messages.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages de Contact - Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .messages-container {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .message-item {
            border-left: 4px solid #1565c0;
            padding: 15px;
            margin-bottom: 15px;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .message-item.non-lu {
            background: #e3f2fd;
            border-left-color: #1976d2;
            font-weight: 500;
        }
        .message-item.repondu {
            background: #e8f5e9;
            border-left-color: #388e3c;
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .message-info {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }
        .message-text {
            background: white;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .status-select {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .message-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 10px 0;
            font-size: 0.9rem;
        }
        .detail-item {
            background: white;
            padding: 8px;
            border-radius: 4px;
        }
        .detail-label {
            font-weight: 600;
            color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>📬 Messages de Contact</h1>
        
        <?php if (empty($messages)): ?>
            <p style="text-align: center; color: #999; padding: 30px;">Aucun message reçu pour le moment.</p>
        <?php else: ?>
            <div class="messages-container">
                <?php foreach ($messages as $msg): ?>
                    <div class="message-item <?php echo $msg['statut']; ?>">
                        <div class="message-header">
                            <div>
                                <strong><?php echo htmlspecialchars($msg['nom']); ?></strong>
                                <span style="color: #666; margin-left: 10px;">(<?php echo htmlspecialchars($msg['email']); ?>)</span>
                            </div>
                            <span style="font-size: 0.8rem; color: #999;">
                                <?php echo date('d/m/Y H:i', strtotime($msg['date_creation'])); ?>
                            </span>
                        </div>
                        
                        <div class="message-details">
                            <?php if (!empty($msg['telephone'])): ?>
                                <div class="detail-item">
                                    <div class="detail-label">Téléphone</div>
                                    <div><?php echo htmlspecialchars($msg['telephone']); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($msg['service'])): ?>
                                <div class="detail-item">
                                    <div class="detail-label">Service</div>
                                    <div><?php echo htmlspecialchars($msg['service']); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="detail-item">
                                <div class="detail-label">Sujet</div>
                                <div><?php echo htmlspecialchars($msg['sujet']); ?></div>
                            </div>
                        </div>
                        
                        <div class="message-info">Message :</div>
                        <div class="message-text"><?php echo htmlspecialchars($msg['message']); ?></div>
                        
                        <div class="btn-group" style="margin-top: 10px;">
                            <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                                <select name="statut" class="status-select" onchange="this.form.submit();">
                                    <option value="non-lu" <?php echo ($msg['statut'] === 'non-lu') ? 'selected' : ''; ?>>Non lu</option>
                                    <option value="lu" <?php echo ($msg['statut'] === 'lu') ? 'selected' : ''; ?>>Lu</option>
                                    <option value="repondu" <?php echo ($msg['statut'] === 'repondu') ? 'selected' : ''; ?>>Répondu</option>
                                </select>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
