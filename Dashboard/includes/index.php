<?php
session_start();

// Sécurité : empêcher l'accès direct si non connecté
if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['role'])) {
    header("Location: login_admin.php");
    exit();
}

$role = $_SESSION['role'];

// Redirection selon le rôle
if ($role === 'president') {
    header("Location: president/statistiques.php");
    exit();
} elseif ($role === 'admin') {
    header("Location: admin/statistiques.php");
    exit();
} else {
    // Si c'est un utilisateur normal, on bloque (il n'est pas censé accéder ici)
    echo "<h2 style='text-align:center; margin-top:100px;'>Accès refusé.</h2>";
    exit();
}
