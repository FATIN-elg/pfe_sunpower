document.addEventListener('DOMContentLoaded', function () {
  const navLinks = document.querySelectorAll('.navbare');
  const currentPage = window.location.pathname.split('/').pop().split('.')[0];

  navLinks.forEach(link => {
    const linkPage = link.getAttribute('data-page');

    if ((currentPage === '' || currentPage === 'index') && linkPage === 'accueil') {
      link.classList.add('active');
    } else if (currentPage === linkPage) {
      link.classList.add('active');
    }
  });

  const header = document.querySelector('header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
});
