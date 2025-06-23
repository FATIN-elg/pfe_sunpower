<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session et inclure la connexion à la base de données
session_start();
require_once '../connect_db.php';

$email = $mot_de_passe = "";
$email_err = $mot_de_passe_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Veuillez entrer votre email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["mot_de_passe"]))) {
        $mot_de_passe_err = "Veuillez entrer votre mot de passe.";
    } else {
        $mot_de_passe = trim($_POST["mot_de_passe"]);
    }

    if (empty($email_err) && empty($mot_de_passe_err)) {
        try {
            $stmt = $conn->prepare("SELECT id_utilisateur, nom, email, mot_de_passe FROM utilisateur WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
                    $_SESSION["user_id"] = $row['id_utilisateur'];
                    $_SESSION["nom"] = $row['nom'];
                    $_SESSION["email"] = $row['email'];

                    header("Location: ../acceuil/index.php");
                    exit;
                } else {
                    $login_err = "Mot de passe incorrect.";
                }
            } else {
                $login_err = "Aucun compte trouvé avec cet email.";
            }
        } catch (PDOException $e) {
            $login_err = "Erreur de connexion : " . $e->getMessage();
        }
    }
}
?>

<!-- On ferme PHP AVANT le HTML -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Sun Power</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: url('assets/images/image4.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .split-container {
            display: flex;
            width: 60%;
            max-width: 1200px;
            height: 600px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .welcome-section {
            flex: 1;
            padding: 10px;
            background: linear-gradient(135deg, rgba(244, 160, 36, 0.9) 20%, rgba(76, 175, 80, 0.9) 50%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            border-radius: 30PX 0px 0px 30px;
            
        }

        .welcome-section img {
            width: 200px;
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-container {
            flex: 1;
            background: #ffffff;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 0px 30px 30px 0px;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-with-icon {
            position: relative;
            width: 100%;
        }

        .input-with-icon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .input-with-icon input {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            user-select: none;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 8px;
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

        .back-home i {
            margin-right: 8px;
            color: white;
        }

        .signup-link {
            margin-top: 20px;
            color: #666;
        }

        .signup-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <a href="../acceuil/index.php" class="back-home">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
    <div class="split-container">
        <div class="welcome-section">
            <h2>BIENVENUE À</h2>
            <img src="../assets/images/WhatsApp_Image_2024-12-27_à_14.11.51_4b09dbd5-removebg-preview.png" alt="Sun Power Logo">
        </div>
        <div class="login-container">
            <h1>Connexion</h1>
            <?php if (!empty($login_err)) echo '<p class="error-message">' . $login_err . '</p>'; ?>
            <form action="login.php" method="post">
                <div class="input-group">
                    <div class="input-with-icon">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" placeholder="Adresse e-mail" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <?php if (!empty($email_err)) echo '<p class="error-message">' . $email_err . '</p>'; ?>
                </div>
                <div class="input-group">
                    <div class="input-with-icon">
                        <i class="fas fa-key"></i>
                        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                    </div>
                    <?php if (!empty($mot_de_passe_err)) echo '<p class="error-message">' . $mot_de_passe_err . '</p>'; ?>
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Rappelles toi</label>
                </div>
                <button type="submit">
                    <i class="fas fa-sign-in-alt"></i> S'identifier
                </button>
                <div class="signup-link">
                    Nouveau sur Sun Power ? <a href="signUp.php">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
