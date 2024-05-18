
function validateCaptcha() {
    const token = grecaptcha.enterprise.getResponse();
    if (!token) {
        alert('Veuillez compléter le captcha.');
        return false;
    } else {
        document.getElementById('submitButton').removeAttribute('disabled');

        return true;
    }
}
