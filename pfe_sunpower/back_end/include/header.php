<!-- /include/header.php -->
 <?php 
 session_start();
 ?>
<header>
  <div class="logo">
    <img src="../assets/images/WhatsApp_Image_2024-12-27_à_14.11.51_4b09dbd5-removebg-preview.png" alt="SUN POWER">
  </div>

  <nav>
    <span><a class="navbare" href="../acceuil/index.php" data-page="accueil">ACCUEIL</a></span>
    <span><a class="navbare" href="../about/about.php" data-page="about">À PROPOS</a></span>
    <span><a class="navbare" href="../services/services.php" data-page="services">SERVICES</a></span>
    <span><a class="navbare" href="../contact/contact.php" data-page="contact">CONTACT</a></span>
  </nav>

  <div class="singup">
  <?php if (isset($_SESSION['nom'])): ?>
    <div style="display: flex; align-items: center; gap: 10px;">
      <div style="background-color: white; border-radius: 50%; padding: 8px;">
        <i class="fas fa-user" style="color: orange;"></i>
      </div>
      <span style="color: white; font-weight: bold;">Bonjour, <?php echo htmlspecialchars($_SESSION['nom']); ?></span>
      <a href="../auth/logout.php" style="color: red; margin-left: 10px; text-decoration: none; font-weight: bold;">Déconnexion</a>
    </div>
  <?php else: ?>
    <span><a class="navbare" href="../auth/login.php" data-page="login">Se connecter</a></span>
  <?php endif; ?>
</div>


</header>

<link rel="stylesheet" href="/include/header.css">
<script src="/include/header.js" defer></script>
