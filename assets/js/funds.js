const button = document.querySelector('#add-funds-button');
const form = document.querySelector('main .wallet-cont form');
const mediaQ = window.matchMedia('(max-width: 950px)');
const formDisplay = document.querySelector('main .wallet-cont .form-display');

button.addEventListener('click', () => {
    if (formDisplay.classList.contains('hidden')) {
        if (mediaQ.matches) {
            formDisplay.classList.remove('hidden');
            formDisplay.classList.add('flex');
        } else {
            formDisplay.classList.remove('hidden');
            formDisplay.classList.add('block');
        }
    } else {
        formDisplay.classList.add('hidden');
        formDisplay.classList.remove('flex', 'block');
    }
});

if (mediaQ.matches) {
    formDisplay.classList.remove('hidden');
    formDisplay.classList.add('flex');
} else {
    formDisplay.classList.remove('hidden');
    formDisplay.classList.add('block');
}