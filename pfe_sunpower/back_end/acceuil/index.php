

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../include/header.css">
    <link rel="stylesheet" href="../include/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <?php include('../include/header.php'); ?>
    <main>
 <!-- home -->
    <article class="art1" id="home">
        <div class="slideshow">
            <div class="slide active" style="background-image: url('../assets/images/slide1.jpg'); background-position: top center;">
                <div class="intraduction">
                    <div class="titel">
                        <h1>BIENVENUE CHEZ SUN POWER</h1>
                        <p>Ensemble, construisons un avenir plus durable grâce à l'énergie solaire.</p>
                        <a href="login.html" class="devis-btn">FAIRE UN DEVIS <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="slide" style="background-image: url('../assets/images/slide2.jpg');">
                <div class="intraduction">
                    <div class="titel">
                        <h1>DÉCOUVREZ NOS PRODUITS</h1>
                        <p>Une large gamme de solutions d'énergie solaire pour tous vos besoins.</p>
                        <a href="produits.html" class="devis-btn">VOIR CATALOGUE <i class="fas fa-book-open"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="slide-dots">
            <div class="dot active"></div>
            <div class="dot"></div>
        </div>
    </article>
</main>

<?php include('../include/footer.php'); ?>
<script>
// Gestion du slideshow
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
let currentSlide = 0;
let slideInterval;

function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    slides[index].classList.add('active');
    dots[index].classList.add('active');
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}

function resetSlideTimer() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
}

// Gestion des points de navigation
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        currentSlide = index;
        showSlide(currentSlide);
        resetSlideTimer();
    });
});

// Démarrer le diaporama automatique
resetSlideTimer();

// Gestion du header au scroll
const header = document.querySelector('header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// Marquer le lien actif dans la navigation
const navLinks = document.querySelectorAll('.navbare');
navLinks.forEach(link => {
    if (link.getAttribute('href') === window.location.hash) {
        link.classList.add('active');
    }
    
    link.addEventListener('click', () => {
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
    });
});

// Gestion des boutons de navigation du slideshow
document.querySelectorAll('.nav-btn.prev').forEach(btn => {
    btn.addEventListener('click', () => {
        prevSlide();
        resetSlideTimer();
    });
});

document.querySelectorAll('.nav-btn.next').forEach(btn => {
    btn.addEventListener('click', () => {
        nextSlide();
        resetSlideTimer();
    });
});
</script>
    <script src="header.js"></script>
    <script>
        // Charger le header
        fetch('header.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('header-placeholder').innerHTML = data;
            });

        // Charger le footer
        fetch('footer.html')
            .then(response => response.text())
            .then(data => {
                document.getElementById('footer-placeholder').innerHTML = data;
            });
    </script>
</body>
</html>