document.getElementById("devis-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const consommation = parseFloat(document.getElementById("quantite").value);
  const ville = document.getElementById("ville").value;
  const batterie = document.getElementById("batterie").value;

  if (!consommation || !ville || !batterie) {
    alert("Veuillez remplir tous les champs.");
    return;
  }

  const irradiation = {
    Rabat: 5.5,
    Tanger: 5.2,
    Tétouane: 5.1,
    Casablanca: 5.4,
    Chefchaouen: 5.0,
  };

  const prixBatteries = {
    "Gel100": 1300,
    "Gel200": 2500,
    "Lithium100": 3500,
    "Lithium200": 6000,
    "LiFePO4150": 7500,
  };

  const batterieNom = {
    "Gel100": "Batterie Gel 100Ah",
    "Gel200": "Batterie Gel 200Ah",
    "Lithium100": "Batterie Lithium 100Ah",
    "Lithium200": "Batterie Lithium 200Ah",
    "LiFePO4150": "Batterie LiFePO4 150Ah",
  };

  const irradiationVille = irradiation[ville];
  const nombreBatteries = Math.ceil(consommation / (irradiationVille * 2));
  const prixUnitaire = prixBatteries[batterie];
  const coutTotal = nombreBatteries * prixUnitaire;

  const devisBody = document.getElementById("devis-body");
  devisBody.innerHTML = `
    <tr>
      <td>${batterieNom[batterie]}</td>
      <td>${prixUnitaire} DH</td>
      <td>${nombreBatteries}</td>
      <td>${coutTotal} DH</td>
    </tr>`;

  document.getElementById("sous-total").textContent = coutTotal;
  document.getElementById("tva").textContent = (coutTotal * 0.2).toFixed(2);
  document.getElementById("total").textContent = (coutTotal * 1.2).toFixed(2);

  document.getElementById("devis-resultat").style.display = "block";
});