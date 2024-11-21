let normalNav = document.querySelectorAll('nav .top-nav .nav-right-container .normal-nav');
let mobileNav = document.querySelector('nav .mobile-nav');
let mediaQuery = window.matchMedia('(max-width: 550px)');
let burgerMenu = document.querySelector('nav .top-nav .nav-right-container .burger-button');
let navBar = document.querySelector('nav .bottom-nav .nav-responsive');

// Handle responsive navigation
function navResponsive(x) {
    if (x.matches) { // Mobile view
        normalNav.forEach(y => y.classList.add('invisibility'));
        mobileNav.classList.remove('invisibility');
    } else { // Desktop view
        normalNav.forEach(y => y.classList.remove('invisibility'));
        mobileNav.classList.add('invisibility');
        navBar.style.display = 'none'; // Reset navBar to hidden
    }
}

// Initialize responsiveness and add media query listener
if (normalNav && mobileNav) {
    navResponsive(mediaQuery);
    mediaQuery.addEventListener('change', navResponsive);
}

// Toggle navigation bar on burger menu click
if (burgerMenu && navBar) {
    burgerMenu.addEventListener('click', () => {
        // Toggle navBar visibility
        if (navBar.style.display === 'none' || navBar.style.display === '') {
            navBar.style.display = 'flex';
        } else {
            navBar.style.display = 'none';
        }
    });
} else {
    console.error("Burger menu or navigation bar is missing in the DOM.");
}
