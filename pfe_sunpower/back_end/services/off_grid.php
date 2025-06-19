<?php
require_once '../include/connect_db.php';

$ville = $batterie = $quantite = "";
$resultat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ville = $_POST["ville"];
  $batterie = $_POST["batterie"];
  $quantite = floatval($_POST["quantite"]);

  $irradiation = [
    "Rabat" => 5.5,
    "Tanger" => 5.2,
    "Tétouane" => 5.1,
    "Casablanca" => 5.4,
    "Chefchaouen" => 5.0
  ];

  $prixBatteries = [
    "Gel100" => 1300,
    "Gel200" => 2500,
    "Lithium100" => 3500,
    "Lithium200" => 6000,
    "LiFePO4150" => 7500
  ];

  $nomsBatteries = [
    "Gel100" => "Batterie Gel 100Ah",
    "Gel200" => "Batterie Gel 200Ah",
    "Lithium100" => "Batterie Lithium 100Ah",
    "Lithium200" => "Batterie Lithium 200Ah",
    "LiFePO4150" => "Batterie LiFePO4 150Ah"
  ];

  if ($ville && $batterie && $quantite > 0 && isset($irradiation[$ville]) && isset($prixBatteries[$batterie])) {
    $irradiationVille = $irradiation[$ville];
    $nombreBatteries = ceil($quantite / ($irradiationVille * 2));
    $prixUnitaire = $prixBatteries[$batterie];
    $coutTotal = $nombreBatteries * $prixUnitaire;
    $tva = $coutTotal * 0.2;
    $totalTTC = $coutTotal + $tva;

    $resultat = "
    <section id='devis-resultat' class='devis-section' style='display:block;'>
      <h2>Résultat du devis</h2>
      <table>
        <thead>
          <tr>
            <th>Type de batterie</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Sous-total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{$nomsBatteries[$batterie]}</td>
            <td>{$prixUnitaire} DH</td>
            <td>{$nombreBatteries}</td>
            <td>{$coutTotal} DH</td>
          </tr>
        </tbody>
        <tfoot>
          <tr><td colspan='3'>TVA (20%)</td><td>" . number_format($tva, 2) . " DH</td></tr>
          <tr><td colspan='3'><strong>Total TTC</strong></td><td><strong>" . number_format($totalTTC, 2) . " DH</strong></td></tr>
        </tfoot>
      </table>
    </section>";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Devis Off-Grid - Sun Power</title>
  <link rel="stylesheet" href="on_grid.css" />
  <link rel="stylesheet" href="header.css" />
  <link rel="stylesheet" href="footer.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>

<?php include '../include/header.php'; ?>

<div class="off-grid-container">
  <h1 class="off-grid-title">Off-Grid</h1>
  <section class="form-section">
    <form method="POST">
      <label for="quantite">Consommation mensuelle (kWh)</label>
      <input type="number" name="quantite" id="quantite" placeholder="Entrez la consommation" required value="<?= htmlspecialchars($quantite) ?>">

      <label for="ville">Localisation</label>
      <select name="ville" id="ville" required>
        <option value="">Choisir une ville</option>
        <?php
        $villes = ["Rabat", "Tanger", "Tétouane", "Casablanca", "Chefchaouen"];
        foreach ($villes as $v) {
          echo "<option value=\"$v\"" . ($ville == $v ? " selected" : "") . ">$v</option>";
        }
        ?>
      </select>

      <label for="batterie">Type de batterie</label>
      <select name="batterie" id="batterie" required>
        <option value="">Sélectionner</option>
        <option value="Gel100" <?= $batterie == "Gel100" ? "selected" : "" ?>>Batterie Gel 100Ah – 1300 DH</option>
        <option value="Gel200" <?= $batterie == "Gel200" ? "selected" : "" ?>>Batterie Gel 200Ah – 2500 DH</option>
        <option value="Lithium100" <?= $batterie == "Lithium100" ? "selected" : "" ?>>Batterie Lithium 100Ah – 3500 DH</option>
        <option value="Lithium200" <?= $batterie == "Lithium200" ? "selected" : "" ?>>Batterie Lithium 200Ah – 6000 DH</option>
        <option value="LiFePO4150" <?= $batterie == "LiFePO4150" ? "selected" : "" ?>>Batterie LiFePO4 150Ah – 7500 DH</option>
      </select>

      <button type="submit">Générer le devis</button>
    </form>
  </section>

  <?= $resultat ?>
</div>

<?php include '../include/footer.php'; ?>

</body>
</html>
