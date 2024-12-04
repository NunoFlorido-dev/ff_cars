const generalButton = document.getElementById('general-page');
const carsButton = document.getElementById('cars-page');
const buttons = document.querySelectorAll('main .select-page button');
const generalPage = document.querySelector('main .general-page-cont');
const carsPage = document.querySelector('main .cars-page-cont');

generalPage.classList.add('display-open');
carsPage.classList.add('display-close');


const lastVisitedPage = localStorage.getItem('lastPage');
if (lastVisitedPage === 'cars') {
    generalPage.classList.add('display-close');
    generalPage.classList.remove('display-open');

    carsPage.classList.add('display-open');
    carsPage.classList.remove('display-close');
}


function switchPage(openPage, closePage, pageName) {
    openPage.classList.add('display-open');
    openPage.classList.remove('display-close');

    closePage.classList.add('display-close');
    closePage.classList.remove('display-open');

    // Salva a página aberta como a última visitada
    localStorage.setItem('lastPage', pageName);
}

buttons.forEach((button) => {
    button.addEventListener('click', () => {
        if (button === generalButton) {
            switchPage(generalPage, carsPage, 'general');
        } else if (button === carsButton) {
            switchPage(carsPage, generalPage, 'cars');
        }
    });
});
