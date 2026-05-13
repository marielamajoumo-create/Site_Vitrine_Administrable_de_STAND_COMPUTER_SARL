# 📋 Formulaire de Contact - Guide d'Installation

## Résumé des modifications

Le formulaire de contact a été amélioré pour :
- ✅ Récupérer **tous les champs** du formulaire (nom, email, téléphone, service, sujet, message)
- ✅ **Enregistrer les données** dans la base de données
- ✅ **Envoyer un email** avec toutes les informations
- ✅ Afficher une **page d'administration** pour consulter les messages

---

## 🔧 Étapes d'installation

### 1. Créer la table dans la base de données

Exécutez le script SQL fourni dans le fichier `create_messages_table.sql` :

```sql
CREATE TABLE IF NOT EXISTS `messages_contact` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `telephone` VARCHAR(20),
  `service` VARCHAR(100),
  `sujet` VARCHAR(255) NOT NULL,
  `message` LONGTEXT NOT NULL,
  `date_creation` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `statut` ENUM('non-lu', 'lu', 'repondu') DEFAULT 'non-lu',
  INDEX `idx_email` (`email`),
  INDEX `idx_date` (`date_creation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Comment exécuter le script :**
- Via phpMyAdmin : Allez dans votre base de données "standcomputer" → onglet "SQL" → Collez le script → Cliquez "Exécuter"
- Via ligne de commande : `mysql -u root standcomputer < create_messages_table.sql`

---

## 📝 Fichiers modifiés

### 1. `contact.php` (formulaire frontend)
- ✅ Ajout des variables JavaScript pour : `telephone`, `service`, `sujet`
- ✅ Envoi de **tous les champs** vers `sendMail.php`
- ✅ Correction du `reset()` du formulaire

### 2. `sendMail.php` (traitement backend)
- ✅ Réception de tous les champs du formulaire
- ✅ **Enregistrement dans la table** `messages_contact` avant d'envoyer l'email
- ✅ Email HTML formaté avec tous les détails
- ✅ Gestion des erreurs améliorée

### 3. `Admin/contacts/messages.php` (nouveau)
- ✅ Page d'administration pour consulter tous les messages
- ✅ Affichage formaté des messages
- ✅ Gestion du statut (non-lu / lu / répondu)
- ✅ Filtrage et tri par date

---

## 🎯 Utilisation

### Pour les clients
1. Ils remplissent le formulaire sur la page `/contact.php`
2. Les données sont envoyées et :
   - ✅ Enregistrées dans la base de données
   - ✅ Un email est reçu par le webmaster

### Pour l'admin
1. Accédez à : `/Admin/contacts/messages.php`
2. Consultez tous les messages reçus
3. Changez le statut des messages (non-lu → lu → répondu)

---

## ⚙️ Configuration

### Modifier les emails destinataires
Éditez `sendMail.php` et changez :
```php
$mail->Username = 'votre-email@gmail.com';
$mail->Password = 'votre-mot-de-passe-app'; // Mot de passe d'application Gmail
```

Pour Gmail, vous devez générer un **mot de passe d'application** :
1. Allez sur : https://myaccount.google.com/apppasswords
2. Générez un mot de passe d'application pour "Mail"
3. Utilisez ce mot de passe dans le code

---

## 🔐 Sécurité

- ✅ Utilisation de `htmlspecialchars()` pour éviter les injections XSS
- ✅ Utilisation de prepared statements (`PDO::prepare()`) pour éviter les injections SQL
- ✅ Les données sont stockées de manière sécurisée dans la base de données

---

## 📊 Structure des données stockées

| Colonne | Type | Description |
|---------|------|-------------|
| `id` | INT | Identifiant unique (clé primaire) |
| `nom` | VARCHAR(100) | Nom du client |
| `email` | VARCHAR(100) | Email du client |
| `telephone` | VARCHAR(20) | Numéro de téléphone (optionnel) |
| `service` | VARCHAR(100) | Service souhaité (optionnel) |
| `sujet` | VARCHAR(255) | Sujet du message |
| `message` | LONGTEXT | Contenu du message |
| `date_creation` | DATETIME | Date et heure d'envoi |
| `statut` | ENUM | État du message (non-lu/lu/repondu) |

---

## ✨ Améliorations possibles

- [ ] Ajouter une réponse automatique au client
- [ ] Implémenter une recherche/filtrage dans la page d'admin
- [ ] Ajouter une pagination pour les messages
- [ ] Exporter les messages en CSV/PDF
- [ ] Ajouter des notifications par email pour les nouveaux messages
- [ ] Implémenter un système de spécification du catégorie/type de demande

---

## 🐛 Dépannage

### Les messages ne s'enregistrent pas
- Vérifiez que la table `messages_contact` a été créée
- Vérifiez les logs d'erreur PHP

### Les emails ne s'envoient pas
- Vérifiez les identifiants Gmail
- Assurez-vous d'utiliser un mot de passe d'application
- Vérifiez que les adresses email des destinataires sont correctes dans la base de données

### Erreur de connexion à la base de données
- Vérifiez la configuration dans `config/db.php`
- Assurez-vous que le service MySQL est démarré

---

## 📞 Support

Pour toute question ou problème, veuillez contacter votre développeur web.
