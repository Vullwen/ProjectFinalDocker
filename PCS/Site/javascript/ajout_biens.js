document.addEventListener('DOMContentLoaded', (event) => {
    const autreRadio = document.getElementById('autre');
    const autreConciergerieInput = document.getElementById('autreConciergerie');
    const radioButtons = document.querySelectorAll('input[name="conciergerie"]');

    radioButtons.forEach(radio => {
        radio.addEventListener('change', () => {
            if (autreRadio.checked) {
                autreConciergerieInput.disabled = false;
                autreConciergerieInput.required = true;
            } else {
                autreConciergerieInput.disabled = true;
                autreConciergerieInput.required = false;
                autreConciergerieInput.value = '';
            }

        });
    });

});


const form = document.getElementById('ajouterBienForm');
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const type = document.getElementById('type').value;
    const adresse = document.getElementById('adresse').value;
    const description = document.getElementById('description').value;
    const superficie = document.getElementById('superficie').value;
    const nbChambres = document.getElementById('nbChambres').value;
    const tarif = document.getElementById('tarif').value;
    let typeConciergerie = document.querySelector('input[name="conciergerie"]:checked').value;
    if (typeConciergerie === 'Autre') {
        typeConciergerie = document.getElementById('autreConciergerie').value;
    }
    const token = document.getElementById('userToken').value;

    try {
        const userApiUrl = `http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id?token=${encodeURIComponent(token)}`;
        const userResponse = await fetch(userApiUrl);
        const userData = await userResponse.json();
        console.log(userData);

        if (userData) {
            const idUtilisateur = userData[0].idutilisateur;

            const apiUrl = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens';
            const data = {
                idutilisateur: idUtilisateur,
                type: type,
                type_conciergerie: typeConciergerie,
                adresse: adresse,
                description: description,
                superficie: superficie,
                nbchambres: nbChambres,
                tarif: tarif
            };
            console.log(data);

            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const result = await response.json();
                alert('Le bien immobilier a été ajouté avec succès.');
                window.location.href = `biensListe.php`;
            } else {
                alert('Erreur lors de l\'ajout du bien immobilier.');
            }
        } else {
            alert('Erreur : utilisateur non trouvé.');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Une erreur est survenue. Veuillez réessayer plus tard.');
    }
});