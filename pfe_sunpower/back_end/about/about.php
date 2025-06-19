<?php include('../include/header.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>À propos - Sun Power</title>

   <link rel="stylesheet" href="../include/header.css">
    <link rel="stylesheet" href="../include/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    * {
  padding: 0px;
  margin: 0px;
  color: rgb(0, 0, 0);
}
/* style de body */
body {
  justify-content: center;
  align-items: center;
}
/* style de header */
header {
  width: 100%;
  display: flex;
  justify-content: space-around;
  padding: 15px 25px;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.95);
  border-bottom: 1px solid rgba(56, 54, 54, 0.1);
  height: 80px;
  position: fixed;
  z-index: 1000;
  backdrop-filter: blur(10px);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

header.scrolled {
  height: 70px;
  background-color: rgba(255, 255, 255, 0.98);
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.15);
}

header .logo {
  height: 100%;
  display: flex;
  align-items: center;
}

header .logo img {
  height: 90%;
  max-height: 60px;
  width: auto;
  transition: all 0.3s ease;
}

header.scrolled .logo img {
  max-height: 50px;
}

header nav {
  display: flex;
  gap: 20px;
}

@media screen and (max-width: 768px) {
  header {
    padding: 10px 15px;
    height: 70px;
  }

  header .logo img {
    max-height: 50px;
  }

  header nav {
    gap: 10px;
  }

  header .singup {
    padding: 8px 15px;
  }
}

.navbare {
  font-weight: bold;
  text-transform: uppercase;
  text-decoration: none;
  padding: 0px 20px;
  color: rgba(5, 5, 6, 0.863);
  transition: 0.4s;
  position: relative;
}

.navbare:hover, .navbare.active {
  color: #f4a024;
}

.navbare.current {
  color: #f4a024;
}

.navbare.current::after {
  width: 80%;
}

.navbare::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  background: #f4a024;
  left: 50%;
  bottom: -5px;
  transform: translateX(-50%);
  transition: 0.3s;
}

.navbare:hover::after, .navbare.active::after {
  width: 70%;
}
/* style de sign-up inclus dans header */
header .singup {
  background-color: #efefef;
  border-radius: 20px;
  padding: 10px 6px;
  transition: all 0.3s ease-in-out;
}

header .singup:hover {
  transform: scale(1.125);
}
/* Media Queries */
@media screen and (max-width: 768px) {
  header {
    padding: 10px;
    font-size: 16px;
  }

  .navbare {
    padding: 0px 10px;
  }

  .slide::before {
    width: 90%;
    height: 90%;
  }

  .footer-container {
    flex-direction: column;
    gap: 30px;
  }

  .footer::after {
    bottom: 80px;
  }
}
.sun-icon {
  font-size: 24px;
  margin-right: 5px;
  color: #f4a024;
}

.team-section {
  padding: 60px 20px;
  background-color: #fff;
  text-align: center;
}

.team-title {
  font-size: 2em;
  color: #f4a024;
  margin-bottom: 40px;
  font-weight: bold;
  position: relative;
}

.team-title::before,
.team-title::after {
  content: "";
  display: inline-block;
  width: 80px;
  height: 3px;
  background: #f4a024;
  vertical-align: middle;
  margin: 0 15px;
}

.team-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 40px;
}

.team-card {
  background: linear-gradient(to bottom, #4caf50, #ffa726);
  color: #fff;
  border-radius: 15px;
  padding: 30px 20px;
  width: 300px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s ease;
}

.team-card:hover {
  transform: translateY(-5px);
}

.team-photo {
  width: 160px;
  height: 160px;
  object-fit: cover;
  border-radius: 50%;
  border: 4px solid white;
  margin-bottom: 15px;
}

.team-card h3 {
  font-size: 1.4em;
  font-weight: bold;
  margin: 10px 0 5px;
}

.team-role {
  font-size: 1em;
  font-weight: 500;
  margin-bottom: 10px;
}

.team-desc {
  font-size: 0.95em;
  line-height: 1.6;
  color: #fffde7;
}

.team-card hr {
  border: none;
  border-top: 2px solid white;
  width: 80%;
  margin: 10px auto;
}

.partners-section {
  text-align: center;
  padding: 60px 20px;
}

.section-title {
  font-size: 24px;
  color: #f7941d;
  font-weight: bold;
  margin-bottom: 40px;
  position: relative;
}

.section-title::before,
.section-title::after {
  content: "";
  display: inline-block;
  width: 60px;
  height: 2px;
  background: #f7941d;
  margin: 0 10px;
  vertical-align: middle;
}

.partners-logos {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 40px;
  align-items: center;
}

.partners-logos img {
  max-width: 160px; /* augmente la taille */
  height: auto;
  transition: transform 0.3s;
}


.partners-logos img:hover {
  transform: scale(1.05);
}


/* Responsive */
@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    align-items: flex-start;
    padding: 0 15px;
  }

  .footer-logo,
  .footer-contact,
  .footer-subscribe {
    min-width: 100%;
  }

  .footer-social {
    justify-content: center;
  }

  .footer::after {
    bottom: 80px;
  }
}

/* Section À propos */
.about-container {
  background-color: #fff;
  padding: 50px 20px;
  max-width: 1200px;
  margin: auto;
}

.about-container h2 {
  text-align: center;
  color: #f4a024;
  font-size: 2.5em;
  margin-bottom: 40px;
}

.about-content {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  justify-content: space-between;
}

.about-text, .about-image {
  flex: 1 1 48%;
  font-size: 1.1em;
  line-height: 1.8;
  color: #333;
  text-align: justify;
}

.about-image img {
  width: 100%;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  transition: transform 0.4s ease;
}

.about-image img:hover {
  transform: scale(1.02);
}

.about-highlight {
  text-align: center;
  margin-top: 40px;
}

.about-highlight p {
  color: #1f8b4c;
  font-size: 1.2em;
  font-weight: bold;
  max-width: 800px;
  margin: auto;
  line-height: 1.6;
}

/* Responsive */
@media (max-width: 960px) {
  .about-content {
    flex-direction: column;
  }

  .about-text, .about-image {
    flex: 1 1 100%;
  }

  .about-container h2 {
    font-size: 2em;
  }

  .about-highlight p {
    font-size: 1.1em;
    padding: 0 10px;
  }
}

  </style>
</head>
<body>

  <!-- Include Header -->
    <div id="header-placeholder"></div>
  <!-- Section À propos -->
  <div class="about-container">
    <h2>À propos de nous</h2>
    
    <div class="about-content">
      <div class="about-text">
        <p><strong>Fondée le 28 février 2023 à Tétouan (Maroc)</strong>, Sun Power est bien plus qu’une simple coopérative : c’est un acteur engagé dans la transition énergétique et l’innovation sociale.</p>
        <p>Nous concevons, produisons et proposons des solutions solaires accessibles, durables et adaptées aux besoins des particuliers comme des professionnels. Notre engagement ne s’arrête pas à la technologie : nous croyons en l’humain, en l’avenir et en un Maroc plus vert.</p>
      </div>
      <div class="about-image">
        <img src="../assets/images/image4.jpg" alt="Équipe Sun Power">
      </div>

      <div class="about-image">
        <img src="../assets/images/image3.jpg" alt="Formation Sun Power">
      </div>
      <div class="about-text">
        <p>Notre coopérative est également un incubateur de talents. Nous soutenons l’intégration professionnelle des jeunes techniciennes et ingénieurs à travers la formation, l’accompagnement et l’expérience terrain.</p>
        <p>Nous organisons régulièrement des ateliers de sensibilisation dans les écoles et les universités, pour faire découvrir aux nouvelles générations les opportunités du solaire et des énergies renouvelables.</p>
      </div>
    </div>

    <div class="about-highlight">
      <p>Rejoindre Sun Power, c’est faire confiance à une équipe passionnée, formée localement, et tournée vers un avenir plus propre, plus juste et plus autonome.</p>
    </div>
  </div>

  <div class="team-section">
  <h2 class="team-title">Notre équipe</h2>
  <div class="team-cards">
    
    <!-- Carte 1 : Houda -->
    <div class="team-card">
      <img src="../assets/images/houda.jpg" alt="Houda Elhau-uari" class="team-photo">
      <h3>Houda Elhau-uari</h3>
      <p class="team-role">Présidente</p>
      <hr>
      <p class="team-desc">
        Spécialiste de l'entrepreneuriat vert nommée par GEDI et la CCIS de Tétouan. Forte expérience en gestion administrative, financière et partenariats.
        Diplômée d’un master en génie énergétique et d’un certificat en fabrication de fours et séchoirs solaires (INES).
      </p>
    </div>

    <!-- Carte 2 : Mariam -->
    <div class="team-card">
      <img src="../assets/images/mariam.jpg" alt="Mariam Es-Sih" class="team-photo">
      <h3>Mariam Es-Sih</h3>
      <p class="team-role">Responsable Communication</p>
      <hr>
      <p class="team-desc">
        Chargée de la stratégie de communication interne et externe. Doctorante en transfert de chaleur et d’énergie. Participe activement à la production de fours et séchoirs solaires.
      </p>
    </div>

    <!-- Carte 3 : Fatin -->
    <div class="team-card">
      <img src="../assets/images/fatin.jpg" alt="Fatin El Ghoual" class="team-photo">
      <h3>Fatin El Ghoual</h3>
      <p class="team-role">Responsable Commerce & Marketing</p>
      <hr>
      <p class="team-desc">
        Expérimentée dans le domaine commercial et les installations solaires. Développe la stratégie marketing de Sun Power et assure le lien avec les clients et partenaires.
      </p>
    </div>
<!-- Carte 4: Latifa Seroukh -->
<div class="team-card">
  <img src="../assets/images/latifa.jpg" alt="Latifa Seroukh" class="team-photo">
  <h3>Latifa Seroukh</h3>
  <p class="team-role">Gérante</p>
  <hr>
  <p class="team-desc">
    Responsable de la fabrication de séchoirs et cuisinières solaires. Mène les activités techniques et artisanales de la coopérative avec engagement et expertise.
  </p>
</div>

<!-- Carte 5 : Houda Awdayer -->
<div class="team-card">
  <img src="../assets/images/houuda.jpg" alt="Houda Awdayer" class="team-photo">
  <h3>Houda Awdayer</h3>
  <p class="team-role">Ambassadrice Solaire</p>
  <hr>
  <p class="team-desc">
    Détentrice d'une licence en Physique, spécialisée en Électronique. Représente la coopérative auprès de réseaux comme WECF, et contribue à l'innovation technique.
  </p>
</div>

  </div>
</div>

<section class="partners-section">
  <h2 class="section-title">Nos partenaires</h2>
  <div class="partners-logos">
    <img src="../assets/images/gedi.png" alt="GEDI">
    <img src="../assets/images/aecid.png" alt="AECID">
    <img src="../assets/images/ministretouristique.jpg" alt="Royaume du Maroc">
    <img src="../assets/images/odico.png" alt="Office Développement">
    <img src="../assets/images/chambrecommerce.png" alt="CCIS">
    <img src="../assets/images/afd.jpeg" alt="AFD">
    <img src="../assets/images/ines (1).png" alt="INES">
    <img src="../assets/images/azimut.jpg" alt="Azimut360">
    <img src="../assets/images/wecf.png" alt="WECF">
    <img src="../assets/images/uir.png" alt="UIR">
    <img src="../assets/images/tangermed.png" alt="Tanger Med">
  </div>
</section>


  <div id="footer-placeholder"></div>

</body>
</html>

<?php include('../include/footer.php'); ?>
