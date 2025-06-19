<?php
require_once 'connect_db.php';
$ville = $panneau = $quantite = $cout_total = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ville = $_POST["ville"];
    $panneau = $_POST["panneau"];
    $quantite = intval($_POST["quantite"]);

    // Coût unitaire selon le panneau
    $prixPanneaux = [
        400 => 2100,
        450 => 2300,
        500 => 2800,
        550 => 3100,
        600 => 3600,
    ];

    $irradiation = [
        "Rabat" => 5.5,
        "Tanger" => 5.2,
        "Tétouane" => 5.1,
        "Casablanca" => 5.4,
        "Chefchaouen" => 5.0,
    ];

    $puissance = intval($panneau);
    $irradiationVille = $irradiation[$ville];
    $production = ($puissance * $irradiationVille * 30) / 1000;
    $nombrePanneaux = ceil($quantite / $production);
    $cout_total = $nombrePanneaux * $prixPanneaux[$puissance];

    // Sauvegarde dans la base de données
    $stmt = $conn->prepare("INSERT INTO simulations (type_systeme, ville, panneau, consommation, quantite_panneaux, cout_total) VALUES ('on-grid', ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiii", $ville, $panneau, $quantite, $nombrePanneaux, $cout_total);
    $stmt->execute();
    $stmt->close();
}
?>
<?php include('../include/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Devis On-Grid - Sun Power</title>
 
  <link rel="stylesheet" href="../include/header.css">
  <link rel="stylesheet" href="../include/footer.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    /* on_grid.css */

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #fdfdfd;
  color: #333;
}

.title {
  text-align: center;
  margin-top: 60px;
  font-size: 1.5em;
  color: #f4a024;
  position: relative;
}

.title::before,
.title::after {
  content: '';
  display: inline-block;
  width: 60px;
  height: 2px;
  background-color: #f4a024;
  margin: 0 15px;
  vertical-align: middle;
}

.form-section {
  max-width: 500px;
  margin: 40px auto;
  padding: 30px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

form label {
  display: block;
  margin: 20px 0 5px;
  font-weight: 600;
}

form input,
form select {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1em;
  margin-bottom: 10px;
}

button[type="submit"] {
  background-color: white;
  color: #f4a024;
  border: 1px solid #f4a024;
  padding: 10px 18px;
  border-radius: 6px;
  cursor: pointer;
  float: right;
  margin-top: 10px;
  transition: all 0.2s ease;
}

button[type="submit"]:hover {
  background-color: #f4a024;
  color: white;
}

.devis-section {
  max-width: 600px;
  margin: 40px auto;
  padding: 20px;
  border-radius: 12px;
  background-color: #fff;
  box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
  text-align: center;
}

.devis-box h2 {
  color: #f4a024;
  margin-bottom: 20px;
}

.devis-box p {
  font-size: 1.1em;
  margin: 10px 0;
}

.devis-logo {
  width: 100px;
  margin-bottom: 15px;
}

  </style>
</head>
<body>
  <div id="header-placeholder"></div>

  <div class="on-grid-container">
    <h1 class="on-grid-title">On-Grid</h1>

    <section class="form-section">
      <form method="POST">
        <label for="quantite">Consommation mensuelle (kWh)</label>
        <input type="number" id="quantite" name="quantite" required value="<?= htmlspecialchars($quantite) ?>">

        <label for="ville">Localisation</label>
        <select id="ville" name="ville" required>
          <option value="">Sélectionner votre ville</option>
          <?php
          foreach (["Rabat", "Tanger", "Tétouane", "Casablanca", "Chefchaouen"] as $v) {
              $selected = ($ville == $v) ? "selected" : "";
              echo "<option value='$v' $selected>$v</option>";
          }
          ?>
        </select>

        <label for="panneau">Type de panneau</label>
        <select id="panneau" name="panneau" required>
          <option value="">Sélectionner un type</option>
          <?php
          foreach ([400 => 2100, 450 => 2300, 500 => 2800, 550 => 3100, 600 => 3600] as $watt => $prix) {
              $selected = ($panneau == $watt) ? "selected" : "";
              echo "<option value='$watt' $selected>Monocristallin {$watt}W - {$prix} DH</option>";
          }
          ?>
        </select>

        <button type="submit">Générer le devis</button>
      </form>
    </section>

    <?php if ($cout_total): ?>
    <section id="devis-resultat" class="devis-section">
      <div class="devis-box">
        <h2>Devis Estimatif - Système On-Grid</h2>
        <p><strong>Ville :</strong> <?= htmlspecialchars($ville) ?></p>
        <p><strong>Panneau :</strong> Monocristallin <?= $panneau ?>W</p>
        <p><strong>Quantité :</strong> <?= $nombrePanneaux ?></p>
        <p><strong>Coût total :</strong> <?= number_format($cout_total, 0, '', ' ') ?> DH</p>
        <button onclick="telechargerPDF()">Télécharger le devis en PDF</button>
      </div>
    </section>
    <?php endif; ?>
  </div>

  <div id="footer-placeholder"></div>

  <script>
    function telechargerPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(16);
      doc.text("Sun Power - Devis On-Grid", 20, 20);
      doc.setFontSize(12);
      doc.text("Ville : <?= $ville ?>", 20, 40);
      doc.text("Panneau : Monocristallin <?= $panneau ?>W", 20, 50);
      doc.text("Quantité : <?= $nombrePanneaux ?>", 20, 60);
      doc.text("Coût total : <?= number_format($cout_total, 0, '', ' ') ?> DH", 20, 70);
      doc.save("devis_on_grid.pdf");
    }

    fetch('header.html').then(r => r.text()).then(d => {
      document.getElementById('header-placeholder').innerHTML = d;
    });
    fetch('footer.html').then(r => r.text()).then(d => {
      document.getElementById('footer-placeholder').innerHTML = d;
    });
  </script>
</body>
</html>
<?php include('../include/footer.php'); ?>