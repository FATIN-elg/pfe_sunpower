document.getElementById("devis-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const consommation = parseFloat(document.getElementById("quantite").value);
  const ville = document.getElementById("ville").value;
  const panneau = document.getElementById("panneau").value;

  if (!consommation || !ville || !panneau) {
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

  const prixPanneaux = {
    400: 2100,
    450: 2300,
    500: 2800,
    550: 3100,
    600: 3600,
  };

  const puissancePanneau = parseInt(panneau);
  const prixUnitaire = prixPanneaux[puissancePanneau];
  const irradiationVille = irradiation[ville];

  const productionMensuelleParPanneau = (puissancePanneau * irradiationVille * 30) / 1000;
  const nombrePanneaux = Math.ceil(consommation / productionMensuelleParPanneau);
  const coutTotal = nombrePanneaux * prixUnitaire;

  // Affichage
  document.getElementById("result-ville").textContent = ville;
  document.getElementById("result-panneau").textContent = `Monocristallin ${puissancePanneau}W - ${prixUnitaire} DH`;
  document.getElementById("result-quantite").textContent = nombrePanneaux;
  document.getElementById("result-prix").textContent = coutTotal.toLocaleString();

  document.getElementById("devis-resultat").style.display = "block";

  // Gestion bouton PDF
  document.getElementById("telecharger-pdf").onclick = () => {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(16);
    doc.text("Sun Power - Devis On-Grid", 20, 20);
    doc.setFontSize(12);
    doc.text(`Ville : ${ville}`, 20, 40);
    doc.text(`Panneau : Monocristallin ${puissancePanneau}W - ${prixUnitaire} DH`, 20, 50);
    doc.text(`Quantité : ${nombrePanneaux}`, 20, 60);
    doc.text(`Coût total : ${coutTotal.toLocaleString()} DH`, 20, 70);

    doc.save("devis_on_grid.pdf");
  };
});
