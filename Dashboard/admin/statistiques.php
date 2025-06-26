<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

// Récupération des statistiques
$stats = array();

// Nombre total d'utilisateurs
$stmt = $pdo->query("SELECT COUNT(*) as total FROM Utilisateur");
$stats['users'] = $stmt->fetch()['total'];

// Nombre total de produits
$stmt = $pdo->query("SELECT COUNT(*) as total FROM Produit");
$stats['products'] = $stmt->fetch()['total'];

// Nombre total de devis
$stmt = $pdo->query("SELECT COUNT(*) as total FROM Devis");
$stats['quotes'] = $stmt->fetch()['total'];

// Devis par jour (pour le graphique)
$stmt = $pdo->query("SELECT DATE(date_creation) as date, COUNT(*) as count 
                     FROM Devis 
                     GROUP BY DATE(date_creation) 
                     ORDER BY date_creation DESC 
                     LIMIT 7");
$quotesPerDay = $stmt->fetchAll();
?>

<!-- Google Fonts - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Votre fichier CSS -->
<link href="/assets/css/style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Tableau de Bord</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Cartes des statistiques -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $stats['users']; ?></h3>
                            <p>Utilisateurs</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $stats['products']; ?></h3>
                            <p>Produits</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $stats['quotes']; ?></h3>
                            <p>Devis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique des devis -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Devis par jour</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="quotesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require_once '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Préparation des données pour le graphique
const dates = <?php echo json_encode(array_column($quotesPerDay, 'date')); ?>;
const counts = <?php echo json_encode(array_column($quotesPerDay, 'count')); ?>;

// Configuration du graphique
const ctx = document.getElementById('quotesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: dates,
        datasets: [{
            label: 'Nombre de devis',
            data: counts,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>