
<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services - Sun Power</title>
  
  <link rel="stylesheet" href="../include/header.css">
    <link rel="stylesheet" href="../acceuil/style.css">
  <link rel="stylesheet" href="../include/footer.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <style>
    .services-container {
    max-width: 1200px;
    margin: 180px 50px 180px 50px; 
    padding: 40px 20px;
}


.services-header {
    text-align: center;
    margin-bottom: 60px;
}

.services-header h1 {
    color: #333;
    font-size: 3em;
    margin-bottom: 20px;
}

.clickable {
    cursor: pointer;
}

.line-decoration {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    margin: 20px auto;
}

.line-left, .line-right {
    height: 4px;
    width: 120px;
    background: linear-gradient(90deg, #f4a024 0%, #ffd280 100%);
    border-radius: 2px;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.service-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-10px);
}

.service-icon {
    font-size: 3em;
    color: #f4a024;
    margin-bottom: 20px;
}

.service-card h3 {
    color: #333;
    font-size: 1.5em;
    margin-bottom: 15px;
}

.service-card p {
    color: #666;
    line-height: 1.6;
}

  </style>
</head>
<body>

  <!-- Include Header -->
  <div id="header-placeholder"></div>
<?php include('../include/header.php'); ?>
  <div class="services-grid">
    
    <!-- Installation Solaire : protégée -->
    <div class="service-card clickable" onclick="window.location.href='<?php echo $isLoggedIn ? 'type_installation.php' : '../auth/login.php'; ?>'">
      <i class="fas fa-solar-panel service-icon"></i>
      <h3>Installation Solaire</h3>
      <p>Installation professionnelle de panneaux solaires pour particuliers et entreprises. Solutions sur mesure adaptées à vos besoins.</p>
    </div>

    <!-- Séchoirs et cuiseurs : public -->
    <div class="service-card clickable" onclick="window.location.href='produits.php'">
      <i class="fas fa-fire service-icon"></i>
      <h3>Fabrication Séchoir et cuiseurs Solaire</h3>
      <p>Conception et fabrication artisanale de séchoirs et cuiseurs solaires pour une utilisation domestique ou professionnelle.</p>
    </div>

    <!-- Formation : non cliquable -->
    <div class="service-card">
      <i class="fas fa-graduation-cap service-icon"></i>
      <h3>Formation & Sensibilisation</h3>
      <p>Programmes de formation et de sensibilisation aux énergies renouvelables pour tous les publics.</p>
    </div>
  </div>

  <!-- Include Footer -->
  <div id="footer-placeholder"></div>

  

</body>
</html>
<?php include('../include/footer.php'); ?>