<!-- includes/sidebar.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    header("Location: /dashboard/login_admin.php");
    exit();
}

$role = $_SESSION['role'];
?>
<div class="sidebar">
    <h2>Dashboard</h2>
    <a href="index.php">Accueil</a>

    <?php if ($role === 'president'): ?>
        <a href="../president/statistiques.php">Statistiques</a>
        <a href="../president/gerer_produits.php">Gérer Produits</a>
        <a href="../president/historique_devis.php">Historique Devis</a>
        <a href="../president/gerer_utilisateurs.php">Gérer Utilisateurs</a>
    <?php elseif ($role === 'admin'): ?>
        <a href="/dashboard/admin/statistiques.php">Statistiques</a>
    <?php endif; ?>

    <a href="/dashboard/logout.php">Déconnexion</a>
</div>
