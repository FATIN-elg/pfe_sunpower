<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';

// Vérification du rôle président
if ($_SESSION['role'] !== 'president') {
    header('Location: ../admin/statistiques.php');
    exit();
}

// Récupération des statistiques de base
$stats = array();

// Statistiques de base (comme dans la version admin)
$stmt = $pdo->query("SELECT COUNT(*) as total FROM Utilisateur");
$stats['users'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM Produit");
$stats['products'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM Devis");
$stats['quotes'] = $stmt->fetch()['total'];

// Statistiques supplémentaires pour le président
// Montant total des devis
$stmt = $pdo->query("SELECT SUM(montant_total) as total FROM Devis");
$stats['total_amount'] = $stmt->fetch()['total'];

// Produits les plus demandés
$stmt = $pdo->query("SELECT p.nom_produit, COUNT(*) as count 
                     FROM Devis_Produit dp 
                     JOIN Produit p ON dp.id_produit = p.id_produit 
                     GROUP BY p.id_produit 
                     ORDER BY count DESC 
                     LIMIT 5");
$topProducts = $stmt->fetchAll();

// Devis par jour (pour le graphique)
$stmt = $pdo->query("SELECT DATE(date_devis) as date, COUNT(*) as count 
                     FROM Devis 
                     GROUP BY DATE(date_devis) 
                     ORDER BY date_devis DESC 
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
            <h1 class="m-0">Tableau de Bord Président</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Cartes des statistiques -->
            <div class="row">
                <div class="col-lg-3 col-6">
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

                <div class="col-lg-3 col-6">
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

                <div class="col-lg-3 col-6">
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

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo number_format($stats['total_amount'], 2); ?> €</h3>
                            <p>Montant Total des Devis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Graphique des devis -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Devis par jour</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="quotesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top produits -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Produits les plus demandés</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="topProductsChart"></canvas>
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
// Graphique des devis par jour
const dates = <?php echo json_encode(array_column($quotesPerDay, 'date')); ?>;
const counts = <?php echo json_encode(array_column($quotesPerDay, 'count')); ?>;

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

// Graphique des produits les plus demandés
const productNames = <?php echo json_encode(array_column($topProducts, 'nom')); ?>;
const productCounts = <?php echo json_encode(array_column($topProducts, 'count')); ?>;

const ctxProducts = document.getElementById('topProductsChart').getContext('2d');
new Chart(ctxProducts, {
    type: 'doughnut',
    data: {
        labels: productNames,
        datasets: [{
            data: productCounts,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 206, 86)',
                'rgb(75, 192, 192)',
                'rgb(153, 102, 255)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'right'
            }
        }
    }
});
</script>