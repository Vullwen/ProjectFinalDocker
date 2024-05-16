resetCaptcha.enterprise.ready(async () => {
    const token = await resetCaptcha.enterprise.execute('6LcdZN0pAAAAAP1E4vuYLTrVG0ZK9tWHLMLYVJcW', { action: 'submit' });
});

function validateCaptcha() {
    const token = resetCaptcha.enterprise.getResponse();
    if (!token) {
        alert('Veuillez compléter le captcha.');
        return false;
    } else {
        document.getElementById('submitButton').removeAttribute('disabled');

        return true;
    }
}

function resetCaptcha() {
    document.getElementById('submitButton').classList.remove('active');
}


