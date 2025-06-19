<?php include('../include/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Types d'installation</title>
    <link rel="stylesheet" href="../include/header.css">
    <link rel="stylesheet" href="../include/footer.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .install-type-container {
            max-width: 1000px;
            margin: 80px auto;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            text-align: center;
        }

      .type-card {
  text-align: center;
  background: #fff;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: transform 0.3s;
  cursor: pointer;
}

.type-card:hover {
  transform: scale(1.05);
}

.type-card img {
  max-width: 120px; /* agrandir les logos */
  height: auto;
  margin-bottom: 15px;
}

    </style>
</head>
<body>

         <!-- Include Header -->
    <div id="header-placeholder"></div>
    <h1 style="text-align:center;">Types d'installation</h1>

    <div class="install-type-container">
      <div class="type-card" onclick="location.href='on_grid.php'">
  <img src="../assets/images/on-grid.jpeg" alt="On-Grid">
  <h3>On-Grid</h3>
   <p>Utilisé pour irriguer ou pomper de l’eau grâce à l’énergie solaire.</p>
</div>

<div class="type-card" onclick="location.href='off_grid.php'">
  <img src="../assets/images/off-grid.jpg" alt="Off-Grid">
  <h3>Off-Grid</h3>
   <p>Utilisé pour irriguer ou pomper de l’eau grâce à l’énergie solaire.</p>
</div>

<div class="type-card" onclick="location.href='pompage.php'">
  <img src="../assets/images/pompage.avif" alt="Pompage">
  <h3>Pompage</h3>
   <p>Utilisé pour irriguer ou pomper de l’eau grâce à l’énergie solaire.</p>
</div>

    </div>
     <div id="footer-placeholder"></div>

 
</body>
</html>
<?php include('../include/footer.php'); ?>