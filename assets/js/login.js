const loginModal = document.getElementById('container_login');
const registerModal = document.getElementById('container_register');

const loginButton = document.getElementById('login_button');
const registerButton = document.getElementById('register_button');

registerButton.addEventListener('click', () => {
  loginModal.style.display = "none";
  registerModal.style.display = "flex";
});

loginButton.addEventListener('click', () => {
   registerModal.style.display = "none";
   loginModal.style.display = "flex";
});