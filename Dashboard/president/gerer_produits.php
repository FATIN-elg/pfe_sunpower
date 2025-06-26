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

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $prix = $_POST['prix'];
                $categorie = $_POST['categorie'];
                
                // Gestion de l'image
                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $filename = $_FILES['image']['name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (in_array($ext, $allowed)) {
                        $newname = uniqid() . '.' . $ext;
                        $destination = '../assets/images/' . $newname;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $image = $newname;
                        }
                    }
                }
                
                $stmt = $pdo->prepare("INSERT INTO Produit (nom_produit, description, prix, categorie, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $description, $prix, $categorie, $image]);
                break;

            case 'update':
                $id = $_POST['id'];
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $prix = $_POST['prix'];
                $categorie = $_POST['categorie'];
                
                // Gestion de l'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $filename = $_FILES['image']['name'];
                    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    
                    if (in_array($ext, $allowed)) {
                        $newname = uniqid() . '.' . $ext;
                        $destination = '../assets/images/' . $newname;
                        
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            // Suppression de l'ancienne image
                            $stmt = $pdo->prepare("SELECT image FROM Produit WHERE id_produit = ?");
                            $stmt->execute([$id]);
                            $old_image = $stmt->fetchColumn();
                            
                            if ($old_image && file_exists('../assets/images/' . $old_image)) {
                                unlink('../assets/images/' . $old_image);
                            }
                            
                            // Mise à jour avec la nouvelle image
                            $stmt = $pdo->prepare("UPDATE Produit SET nom = ?, description = ?, prix = ?, categorie = ?, image = ? WHERE id_produit = ?");
                            $stmt->execute([$nom, $description, $prix, $categorie, $newname, $id]);
                        }
                    }
                } else {
                    // Mise à jour sans changer l'image
                    $stmt = $pdo->prepare("UPDATE Produit SET nom = ?, description = ?, prix = ?, categorie = ? WHERE id_produit = ?");
                    $stmt->execute([$nom, $description, $prix, $categorie, $id]);
                }
                break;

            case 'delete':
                $id = $_POST['id'];
                
                // Suppression de l'image
                $stmt = $pdo->prepare("SELECT image FROM Produit WHERE id_produit = ?");
                $stmt->execute([$id]);
                $image = $stmt->fetchColumn();
                
                if ($image && file_exists('../assets/images/' . $image)) {
                    unlink('../assets/images/' . $image);
                }
                
                $stmt = $pdo->prepare("DELETE FROM Produit WHERE id_produit = ?");
                $stmt->execute([$id]);
                break;
        }
        
        header('Location: gerer_produits.php');
        exit();
    }
}

// Récupération de tous les produits
$stmt = $pdo->query("SELECT * FROM Produit ORDER BY nom_produit");
$produits = $stmt->fetchAll();
?>
<!-- Google Fonts - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Votre fichier CSS -->
<link href="/assets/css/style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Gestion des Produits</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Bouton pour ajouter un produit -->
            <div class="row mb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                        <i class="fas fa-plus"></i> Ajouter un produit
                    </button>
                </div>
            </div>

            <!-- Liste des produits -->
            <div class="row">
                <?php foreach ($produits as $produit): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if ($produit['image']): ?>
                        <img src="../assets/images/<?php echo htmlspecialchars($produit['image']); ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($produit['nom_produit']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($produit['nom_produit']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($produit['description']); ?></p>
                            <p class="card-text"><strong>Prix:</strong> <?php echo number_format($produit['prix'], 2); ?> €</p>
                            <p class="card-text"><strong>Catégorie:</strong> <?php echo htmlspecialchars($produit['categorie']); ?></p>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-info" 
                                        onclick="editProduct(<?php echo htmlspecialchars(json_encode($produit)); ?>)">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="deleteProduct(<?php echo $produit['id_produit']; ?>)">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- Modal Ajout Produit -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un produit</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" value="create">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Prix</label>
                        <input type="number" name="prix" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select name="categorie" class="form-control" required>
                            <option value="Cuiseur solaire">Cuiseur solaire</option>
                            <option value="Séchoir solaire">Séchoir solaire</option>
                            <option value="Pompage solaire">Pompage solaire</option>
                            <option value="Installation On-grid">Installation On-grid</option>
                            <option value="Installation Off-grid">Installation Off-grid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modification Produit -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le produit</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" id="edit_nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Prix</label>
                        <input type="number" name="prix" id="edit_prix" step="0.01" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select name="categorie" id="edit_categorie" class="form-control" required>
                            <option value="Cuiseur solaire">Cuiseur solaire</option>
                            <option value="Séchoir solaire">Séchoir solaire</option>
                            <option value="Pompage solaire">Pompage solaire</option>
                            <option value="Installation On-grid">Installation On-grid</option>
                            <option value="Installation Off-grid">Installation Off-grid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nouvelle image (laisser vide pour conserver l'actuelle)</label>
                        <input type="file" name="image" class="form-control-file" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="id" id="delete_id">
</form>

<?php require_once '../includes/footer.php'; ?>

<script>
function editProduct(product) {
    document.getElementById('edit_id').value = product.id_produit;
    document.getElementById('edit_nom').value = product.nom;
    document.getElementById('edit_description').value = product.description;
    document.getElementById('edit_prix').value = product.prix;
    document.getElementById('edit_categorie').value = product.categorie;
    $('#editProductModal').modal('show');
}

function deleteProduct(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        document.getElementById('delete_id').value = id;
        document.getElementById('deleteForm').submit();
    }
}
</script>