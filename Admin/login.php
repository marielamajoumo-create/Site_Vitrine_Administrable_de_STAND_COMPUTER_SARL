
  
 <?php
 /*
session_start();
include '../config/db.php';

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=? AND passwor=?");
    $stmt->execute([$username, $password]);

    if($stmt->rowCount() > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
    } else {
        echo "Identifiants incorrects";
    }
}
?>


<form method="POST">
    <input type="text" name="username" placeholder="Nom d'utilisateur">
    <input type="password" name="password" placeholder="Mot de passe">
    <button type="submit" name="login">Connexion</button>
</form> 




<?php */
session_start();
include '../config/db.php';
 $error='';

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username=? AND passwor=?");
    $stmt->execute([$username, $password]);

    if($stmt->rowCount() > 0) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit () ;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion Admin - Stand Computer</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(135deg, #0a1628 0%, #0f1a2e 50%, #0a1628 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #1565C0, #FF6B00);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .logo-icon .material-icons-round {
            font-size: 36px;
            color: white;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
        }

        /* Message d'erreur simple et discret */
        .error-simple {
            background: rgba(255,68,68,0.1);
            border-left: 3px solid #ff4444;
            padding: 10px 12px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .error-simple span {
            color: #ff8888;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 0.75rem;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 4px 16px;
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within {
            border-color: #FF6B00;
            box-shadow: 0 0 0 3px rgba(255,107,0,0.2);
        }

        .input-wrapper .material-icons-round {
            color: rgba(255,255,255,0.4);
            font-size: 20px;
            margin-right: 12px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 0;
            background: transparent;
            border: none;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            outline: none;
        }

        .input-wrapper input::placeholder {
            color: rgba(255,255,255,0.3);
        }

        .btn-login {
            background: linear-gradient(135deg, #FF6B00, #e05a00);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #e05a00, #c44f00);
            transform: scale(1.02);
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #FF6B00;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <div class="logo-icon">
                <span class="material-icons-round">computer</span>
            </div>
            <h1>Stand Computer</h1>
            <p>Espace d'administration</p>
        </div>

        <!-- Message d'erreur simple, seulement si erreur -->
        <?php if($error): ?>
        <div class="error-simple">
            <span>⚠️ <?php echo $error; ?></span>
        </div>
        <?php endif; ?>

        <form method="POST" class="login-form">
            <div class="input-group">
                <label>Nom d'utilisateur</label>
                <div class="input-wrapper">
                    <span class="material-icons-round">person_outline</span>
                    <input type="text" name="username" placeholder="admin" required autofocus>
                </div>
            </div>

            <div class="input-group">
                <label>Mot de passe</label>
                <div class="input-wrapper">
                    <span class="material-icons-round">lock_outline</span>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn-login">
                Se connecter
                <span class="material-icons-round">arrow_forward</span>
            </button>
        </form>

        <div class="back-link">
            <a href="../index.php">
                <span class="material-icons-round">arrow_back</span>
                Retour au site
            </a>
        </div>
    </div>
</div>

</body>
</html>

