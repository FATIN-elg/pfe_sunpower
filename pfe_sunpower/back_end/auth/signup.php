<?php
$errors = [
    'prenom' => '',
    'nom' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => ''
];

$prenom = $nom = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../connect_db.php'; 
    
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($prenom) || !preg_match("/^[a-zA-ZÀ-ÿ\- ]+$/", $prenom)) {
        $errors['prenom'] = "Prénom invalide.";
    }

    if (empty($nom) || !preg_match("/^[a-zA-ZÀ-ÿ\- ]+$/", $nom)) {
        $errors['nom'] = "Nom invalide.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "E-mail invalide.";
    }

    if (strlen($password) < 8) {
        $errors['password'] = "Le mot de passe doit comporter au moins 8 caractères.";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
    }

    // Si tout est bon
    if (!array_filter($errors)) {
        $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $errors['email'] = "Cet e-mail est déjà utilisé.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO utilisateur (prénom, nom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
            $stmt->execute([$prenom, $nom, $email, $hashedPassword]);
            header("Location: login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Inscription - Sun Power</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <style>
                * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: url('../assets/images/image4.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .split-container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            height: auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .welcome-section {
            flex: 1;
            padding: 40px;
            background: linear-gradient(135deg, rgba(244, 160, 36, 0.9) 0%, rgba(76, 175, 80, 0.9) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .welcome-section h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .features-list {
            text-align: left;
            width: 100%;
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .feature-item i {
            margin-right: 15px;
            margin-top: 3px;
        }

        .feature-text {
            flex: 1;
        }

        .feature-text h3 {
            margin-bottom: 5px;
        }

        .signup-container {
            flex: 1;
            background: #ffffff;
            padding: 40px;
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .signup-header {
            margin-bottom: 30px;
        }

        .signup-header h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .form-group .hint {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .newsletter-checkbox {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .newsletter-checkbox label {
            display: flex;
            align-items: flex-start;
            color: #666;
            font-size: 14px;
        }

        .newsletter-checkbox input[type="checkbox"] {
            margin-right: 10px;
            margin-top: 3px;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .terms {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        .terms a {
            color: #4CAF50;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .back-home:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .login-title {
            position: absolute;
            top: 20px;
            right: 12px;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 12px;
            font-weight: lighter;
        }

        .login-title a {
            color: #0000FF;
            text-decoration: underline;
            font-weight: bold;
            margin-left: 5px;
        }

        .back-home i {
            margin-right: 8px;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <a href="../acceuil/index.php" class="back-home">
        <i class="fas fa-arrow-left"></i> Retour 
    </a>
    <div class="split-container">
        <div class="welcome-section">
            <h2>Créez votre compte gratuitement</h2>
            <div class="features-list">
                <!-- tes fonctionnalités -->
                <div class="feature-item">
                    <i class="fas fa-solar-panel"></i>
                    <div class="feature-text">
                        <h3>Simulation personnalisée</h3>
                        <p>Choisissez votre type d'installation...</p>
                    </div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <div class="feature-text">
                        <h3>Devis automatique</h3>
                        <p>Un devis est généré automatiquement...</p>
                    </div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-box-open"></i>
                    <div class="feature-text">
                        <h3>Matériel fiable</h3>
                        <p>Notre base contient différents modèles...</p>
                    </div>
                </div>
                <div class="feature-item">
                    <i class="fas fa-lock"></i>
                    <div class="feature-text">
                        <h3>Espace sécurisé</h3>
                        <p>Créez votre profil, sauvegardez vos simulations...</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="signup-container">
            <h1 class="login-title">Vous avez déjà un compte ? <a href="logIn.php">Se connecter</a></h1>
            <div class="signup-header">
                <h1>Inscrivez-vous sur Sun Power</h1>
            </div>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="prenom">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom) ?>" required>
                    <div class="hint">Le prénom d'utilisateur ne peut contenir que des lettres et tirets simples.</div>
                    <?php if ($errors['prenom']): ?><div class="error-message"><?= $errors['prenom'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nom">Nom *</label>
                    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom) ?>" required>
                    <div class="hint">Le nom d'utilisateur ne peut contenir que des lettres et tirets simples.</div>
                    <?php if ($errors['nom']): ?><div class="error-message"><?= $errors['nom'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    <?php if ($errors['email']): ?><div class="error-message"><?= $errors['email'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" name="password" required>
                    <div class="hint">Le mot de passe doit comporter au moins 8 caractères.</div>
                    <?php if ($errors['password']): ?><div class="error-message"><?= $errors['password'] ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmer mot de passe *</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <?php if ($errors['confirm_password']): ?><div class="error-message"><?= $errors['confirm_password'] ?></div><?php endif; ?>
                </div>
                <div class="newsletter-checkbox">
                    <label>
                        <input type="checkbox" name="newsletter">
                        <span>Recevez occasionnellement des mises à jour et des annonces de produits.</span>
                    </label>
                </div>
                <button type="submit">Continuer <i class="fas fa-arrow-right"></i></button>
                <div class="terms">
                    En créant un compte, vous acceptez les <a href="#">Conditions d'utilisation</a> et la <a href="#">Politique de confidentialité</a>.
                </div>
            </form>
        </div>
    </div>
</body>
</html>
