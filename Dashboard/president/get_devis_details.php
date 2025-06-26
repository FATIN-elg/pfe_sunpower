<?php
require_once '../config/database.php';
require_once '../includes/auth_check.php';

// Vérification du rôle
if ($_SESSION['role'] !== 'president' && $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Accès non autorisé');
}

if (!isset($_GET['id'])) {
    header('HTTP/1.1 400 Bad Request');
    exit('ID non fourni');
}

$id = $_GET['id'];

// Récupération des informations du devis
$stmt = $pdo->prepare("SELECT d.*, u.nom as client_nom, u.prenom as client_prenom, u.email as client_email 
                       FROM Devis d 
                       LEFT JOIN Utilisateur u ON d.id_utilisateur = u.id_utilisateur 
                       WHERE d.id_devis = ?");
$stmt->execute([$id]);
$devis = $stmt->fetch();

if (!$devis) {
    header('HTTP/1.1 404 Not Found');
    exit('Devis non trouvé');
}

// Récupération des produits du devis
$stmt = $pdo->prepare("SELECT dp.*, p.nom, p.prix 
                       FROM Devis_Produit dp 
                       JOIN Produit p ON dp.id_produit = p.id_produit 
                       WHERE dp.id_devis = ?");
$stmt->execute([$id]);
$produits = $stmt->fetchAll();
?>

<!-- Google Fonts - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Votre fichier CSS -->
<link href="/assets/css/style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="row">
    <div class="col-md-6">
        <h6>Informations Client</h6>
        <table class="table table-bordered">
            <tr>
                <th>Nom</th>
                <td><?php echo htmlspecialchars($devis['client_prenom'] . ' ' . $devis['client_nom']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($devis['client_email']); ?></td>
            </tr>
            <tr>
                <th>Date de création</th>
                <td><?php echo date('d/m/Y H:i', strtotime($devis['date_creation'])); ?></td>
            </tr>
            <tr>
                <th>Statut</th>
                <td>
                    <span class="badge badge-<?php 
                        echo $devis['statut'] === 'Validé' ? 'success' : 
                            ($devis['statut'] === 'Refusé' ? 'danger' : 'warning'); 
                        ?>">
                        <?php echo $devis['statut']; ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6>Détails de la commande</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p['nom']); ?></td>
                    <td><?php echo $p['quantite']; ?></td>
                    <td><?php echo number_format($p['prix'], 2); ?> €</td>
                    <td><?php echo number_format($p['prix'] * $p['quantite'], 2); ?> €</td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th><?php echo number_format($devis['montant_total'], 2); ?> €</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php if (!empty($devis['commentaire'])): ?>
<div class="row mt-3">
    <div class="col-12">
        <h6>Commentaire</h6>
        <div class="card">
            <div class="card-body">
                <?php echo nl2br(htmlspecialchars($devis['commentaire'])); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>