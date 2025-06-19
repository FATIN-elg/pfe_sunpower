document.getElementById("devis-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const consommation = parseFloat(document.getElementById("quantite").value);
  const ville = document.getElementById("ville").value;
  const pompe = document.getElementById("pompe").value;

  if (!consommation || !ville || !pompe) {
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

  const prixPompes = {
    "0.5ch": 2800,
    "1ch": 4500,
    "1.5ch": 6000,
    "2ch": 7500,
    "3ch": 10000,
  };

  const pompeNom = {
    "0.5ch": "Pompe 0.5 ch - 370 W",
    "1ch": "Pompe 1 ch - 750 W",
    "1.5ch": "Pompe 1.5 ch - 1100 W",
    "2ch": "Pompe 2 ch - 1500 W",
    "3ch": "Pompe 3 ch - 2200 W",
  };

  const irradiationVille = irradiation[ville];
  const nombrePompes = Math.ceil(consommation / (irradiationVille * 1.5));
  const prixUnitaire = prixPompes[pompe];
  const coutTotal = nombrePompes * prixUnitaire;

  const devisBody = document.getElementById("devis-body");
  devisBody.innerHTML = `
    <tr>
      <td>${pompeNom[pompe]}</td>
      <td>${prixUnitaire} DH</td>
      <td>${nombrePompes}</td>
      <td>${coutTotal} DH</td>
    </tr>`;

  document.getElementById("sous-total").textContent = coutTotal;
  document.getElementById("tva").textContent = (coutTotal * 0.2).toFixed(2);
  document.getElementById("total").textContent = (coutTotal * 1.2).toFixed(2);

  document.getElementById("devis-resultat").style.display = "block";
});
