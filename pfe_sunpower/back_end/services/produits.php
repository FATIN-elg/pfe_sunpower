
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nos produits - Sun Power</title>
  <link rel="stylesheet" href="../acceuil/style.css">
  <link rel="stylesheet" href="../include/header.css" />
  <link rel="stylesheet" href="../include/footer.css" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    /* ---- Style général de la page ---- */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #fff;
  color: #333;
}

/* ---- Titre de section ---- */
.section-title {
  text-align: center;
  color: #f7a823;
  font-size: 1.5rem;
  font-weight: bold;
  margin: 40px 0 20px;
  position: relative;
}

.section-title::before,
.section-title::after {
  content: '';
  position: absolute;
  top: 50%;
  width: 100px;
  height: 2px;
  background: #f7a823;
}

.section-title::before {
  left: calc(50% - 140px);
}

.section-title::after {
  right: calc(50% - 140px);
}

/* ---- Grille de produits ---- */
.produits-grid {
  display: flex;
  justify-content: center;
  gap: 40px;
  flex-wrap: wrap;
  padding: 40px 20px;
}

/* ---- Carte individuelle de produit ---- */
.produit-card {
  width: 250px;
  min-height: 350px;
  background: #f9f9f9;
  border-radius: 15px;
  text-align: center;
  padding: 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s;
}

.produit-card:hover {
  transform: translateY(-5px);
}

/* ---- Image produit ---- */
.produit-card img {
  height: 180px;
  object-fit: contain;
  margin-bottom: 15px;
}

/* ---- Titre produit ---- */
.produit-card h3 {
  margin-bottom: 10px;
  font-size: 1.1rem;
  color: #333;
}

/* ---- Bouton consulter détails ---- */
.btn-detail {
  display: inline-block;
  padding: 10px 15px;
  background-color: #f7a823;
  color: white;
  text-decoration: none;
  border-radius: 8px;
  font-weight: bold;
  margin-top: 10px;
  transition: background 0.3s;
}

.btn-detail:hover {
  background-color: #e69512;
}

  </style>
</head>
<body>
<?php include '../include/header.php'; ?>
  <!-- En-tête -->
  <div id="header-placeholder"></div>

  <!-- Titre principal -->
  <h2 class="section-title">Nos produits</h2>

  <!-- Grille des produits -->
  <div class="produits-grid">
  
    <!-- Cuiseur 1 -->
    <div class="produit-card">
      <img src="../assets/images/cuiseur1.png" alt="Cuiseur solaire 1">
      <h3>Cuiseur solaire</h3>
      <a href="detail_cuiseur_1.php" class="btn-detail">Consulter détails <i class="fas fa-arrow-right"></i></a>
    </div>

    <!-- Cuiseur 2 -->
    <div class="produit-card">
      <img src="../assets/images/cuiseur2.png" alt="Cuiseur solaire 2">
      <h3>Cuiseur solaire</h3>
      <a href="detail_cuiseur_2.php" class="btn-detail">Consulter détails <i class="fas fa-arrow-right"></i></a>
    </div>

    <!-- Séchoir -->
    <div class="produit-card">
      <img src="../assets/images/séchoir.png" alt="Séchoir solaire">
      <h3>Séchoir solaire</h3>
      <a href="detail_sechoir.php" class="btn-detail">Consulter détails <i class="fas fa-arrow-right"></i></a>
    </div>

  </div>

  <!-- Pied de page -->
  <div id="footer-placeholder"></div>
<?php include '../include/footer.php'; ?>
 
</body>
</html>
