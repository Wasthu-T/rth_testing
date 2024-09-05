const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
const passwordConfirmation = document.querySelector('#password_confirmation');

if (togglePassword) {
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });
};

if (togglePasswordConfirmation) {
    togglePasswordConfirmation.addEventListener('click', function () {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        this.querySelector('i').classList.toggle('bi-eye');
        this.querySelector('i').classList.toggle('bi-eye-slash');
    });
}