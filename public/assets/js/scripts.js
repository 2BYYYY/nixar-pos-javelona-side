/*
* AUTHOR/S:
* - Raean Chrissean Tamayo
* - Jul Leo Javellana
* */

const toggleMenu = () => {
    const menu = document.querySelector('.mobile-nav-links');
    menu.classList.toggle('d-flex');
    menu.classList.toggle('d-none');
}

// nav selected
document.addEventListener('DOMContentLoaded', function() {
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('.nav-link');

  navLinks.forEach(link => {
    const anchor = link.querySelector('a');
    if (!anchor) return;

    const href = anchor.getAttribute('href');
    const PAGES = ['inventory', 'transaction', 'reports'];

    const isIncluded = PAGES.find(keyword => 
        currentPath.includes(keyword) && href.includes(keyword)
    );

    if (isIncluded) {
      link.classList.add('nav-selected');
    }
  });
});