/*
* AUTHOR/S:
* - Raean Chrissean Tamayo
* - Jul Leo Javellana
* - John Roland Octavio (Toast Logic)
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


const showToast = (message, type = "info") => {
    const container = document.getElementById('toast-container');

    const toast = document.createElement('div');
    const icon =
        type === 'success'
            ? "fa-solid fa-check"
            : type === 'error'
                ? "fa-solid fa-x"
                : "fa-regular fa-lightbulb";

    toast.className = `toast ${type} px-2 py-1 d-flex align-items-center fs-7`;
    toast.innerHTML = `
        <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center me-2" 
            style="width: 28px; height: 28px;"
        >
            <i class="${icon} text-white fs-6"></i>
        </div>
        <span class="flex-grow-1 text-wrap">${message}</span>
        <button class="rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center ms-2">
            <i class="fa-solid fa-xmark"></i>
        </button>
  `;
    container.appendChild(toast);

    // Trigger show animation
    setTimeout(() => toast.classList.add('show'), 50);

    // Remove after 3s
    // const timeoutId = setTimeout(() => hideToast(toast), 2000);

    // Handle manual close
    toast.querySelector('button').addEventListener('click', () => {
        clearTimeout(timeoutId);
        hideToast(toast);
    });
}

const hideToast = (toast) => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
}