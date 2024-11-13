// JavaScript for responsive nav toggle
let getMobileSize = window.matchMedia("(max-width: 550px)");
let normalNav = document.querySelectorAll('nav .normal-nav');
let mobileNav = document.querySelector('nav .nav-mobile');
let burgerButton = document.querySelector('.burger-button');

function toggleNavVisibility(x) {
    if (x.matches) {
        normalNav.forEach(navItem => navItem.classList.add('invisibility'));
        mobileNav.classList.remove('invisibility');
        burgerButton.classList.remove('invisibility');
    } else {
        normalNav.forEach(navItem => navItem.classList.remove('invisibility'));
        mobileNav.classList.add('invisibility');
        burgerButton.classList.add('invisibility');
    }
}

toggleNavVisibility(getMobileSize);
getMobileSize.addEventListener('change', toggleNavVisibility);


let navMobileMenu = document.querySelector('.nav-mobile');

navMobileMenu.style.navList = 'none';
burgerButton.addEventListener(('click'), () => {

navMobileMenu.classList.toggle('nav-list');

});