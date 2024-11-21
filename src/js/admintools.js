const generalButton = document.getElementById('general-page');
const carsButton = document.getElementById('cars-page');
const buttons = document.querySelectorAll('main .select-page button');
const generalPage = document.querySelector('main .general-page-cont');
const carsPage = document.querySelector('main .cars-page-cont');


generalPage.classList.add('display-open');
carsPage.classList.add('display-close');

buttons.forEach((button) => {
button.addEventListener('click', () => {
    if(button === generalButton){
        generalPage.classList.add('display-open');
        generalPage.classList.remove('display-close');

        carsPage.classList.add('display-close');
        carsPage.classList.remove('display-open');
    }
    if(button === carsButton){
        carsPage.classList.add('display-open');
        carsPage.classList.remove('display-close');

        generalPage.classList.add('display-close');
        generalPage.classList.remove('display-open');



    }
});

});