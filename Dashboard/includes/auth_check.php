<!-- includes/auth_check.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email']) || !isset($_SESSION['role'])) {
    header("Location: /back_end_sunpower/Dashboard/login_admin.php");
    exit();
}

// Vérification des accès selon le rôle
$current_path = $_SERVER['PHP_SELF'];
if (strpos($current_path, '/admin/') !== false && $_SESSION['role'] !== 'admin') {
    header("Location: /back_end_sunpower/Dashboard/login_admin.php");
    exit();
}
if (strpos($current_path, '/president/') !== false && $_SESSION['role'] !== 'president') {
    header("Location: /back_end_sunpower/Dashboard/login_admin.php");
    exit();
}
?>

