<?php
session_start();
require_once 'config/database.php';

$erreur = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $code = $_POST['code'];

    if (!empty($email) && !empty($code)) {
        // Vérification dans la base de données
        $query = "SELECT * FROM Utilisateur WHERE email = :email AND mot_de_passe = :code AND (role = 'admin' OR role = 'president')";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':email' => $email,
            ':code' => $code
        ]);
        
        $utilisateur = $stmt->fetch();
        
        if ($utilisateur) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $utilisateur['role'];
            
            // Redirection selon le rôle
            if ($utilisateur['role'] === 'president') {
                header('Location: president/statistiques.php');
            } else {
                header('Location: admin/statistiques.php');
            }
            exit();
        } else {
            $erreur = "Email ou code incorrect";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Sun Power Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-container">
        <h2>Sun Power Dashboard</h2>
        <?php if ($erreur): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erreur); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="code">Code d'accès</label>
                <input type="password" id="code" name="code" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
    </div>
</body>
</html>
