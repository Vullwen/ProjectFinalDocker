<?php

include_once '../template/header.php';
?>


<h1 id="titleFormBailleur"> Devenir Bailleur chez ParisCareTaker ! </h1>

<form id="devenirBailleurForm" onsubmit="validateForm()">
    <div class="form-group">
        <label for="conciergerie">Quel type de conciergerie souhaitez-vous ?<span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="radio" id="aaz" name="conciergerie" value="De A à Z">
        <label for="aaz">De A à Z</label><br>
        <input type="radio" id="void" name="conciergerie" value="Void management">
        <label for="void">Void management (création, diffusion et optimisatioon de vos revenus)</label><br>
        <input type="radio" id="autre" name="conciergerie" value="Autre">
        <label for="autre">Autre</label><br>
        <input type="text" id="autreConciergerie" name="autreConciergerie" placeholder="Autre (précisez)">
    </div>

    <div class="form-group">
        <label for="adresse">Adresse de votre propriété en location courte durée <span class="obligatoire">
                (obligatoire)</span>:</label><br>
        <input type="text" id="adresse" name="adresse" required>
    </div>
    <div class="form-group">
        <label for="ville">Ville <span class="obligatoire">(obligatoire)</span>:</label><br>
        <input type="text" id="ville" name="ville" required>
    </div>

    <div class="form-group">
        <label for="codePostal">Code postal <span class="obligatoire">(obligatoire)</span>:</label><br>
        <input type="text" id="codePostal" name="codePostal" required>
    </div>

    <div class="form-group">
        <label for="pays">Pays de votre propriété en location courte durée <span class="obligatoire">
                (obligatoire)</span></label><br>
        <select id="pays" name="pays">
            <option value="France">France</option>
            <option value="Espagne">Espagne</option>
            <option value="Italie">Italie</option>
            <option value="Allemagne">Allemagne</option>
            <option value="Royaume-Uni">Royaume-Uni</option>
            <option value="Belgique">Belgique</option>
            <option value="Suisse">Suisse</option>

        </select>
    </div>

    <div class="form-group">
        <label for="typeBien">Type de bien <span class="obligatoire">
                (obligatoire)</span></label><br>
        <select id="typeBien" name="typeBien">
            <option value="Appartement">Appartement</option>
            <option value="Maison">Maison</option>
        </select>
    </div>

    <div class="form-group">
        <label for="typeLocation">Type de location<span class="obligatoire">
                (obligatoire)</span> </label><br>
        <select id="typeLocation" name="typeLocation">
            <option value="Logement complet">Logement complet</option>
            <option value="Chambres">Chambres</option>
            <option value="Colocation">Colocation</option>
        </select>
    </div>

    <div class="form-group">
        <label for="superficie">Superficie (en m²)<span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="number" id="superficie" name="superficie" required>

        <div class="form-group">
            <label for="nombreChambres">Nombre de chambres <span class="obligatoire">
                    (obligatoire)</span></label><br>
            <input type="number" id="nombreChambres" name="nombreChambres" required>
        </div>

        <div class="form-group">
            <label for="capacite">Quelle est la capacité d'accueil de votre logement ?<span class="obligatoire">
                    (obligatoire)</span></label><br>
            <select id="capacite" name="capacite" required>
                <option value="1">1 personne</option>
                <option value="2">2 personnes</option>
                <option value="3">3 personnes</option>
                <option value="4">4 personnes</option>
                <option value="5">5 personnes</option>
                <option value="6">6 personnes</option>
                <option value="7">7 personnes</option>
                <option value="8">8 personnes</option>
                <option value="9">9 personnes</option>
                <option value="10">10 personnes</option>
                <option value="11">11 personnes</option>
                <option value="12+">12 personnes et plus</option>
            </select>
        </div>

        <div class="form-group">
            <label for="nom">Nom et Prénom <span class="obligatoire">
                    (obligatoire)</span></label><br>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="obligatoire">
                    (obligatoire)</span></label><br>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone<span class="obligatoire">
                    (obligatoire)</span></label><br>
            <input type="tel" id="telephone" name="telephone" required>
        </div>

        <div class="form-group">
            <label>A quelle heure souhaitez-vous être contacté ?<span class="obligatoire">
                    (obligatoire)</span></label><br>
            <input type="radio" id="avant12h" name="contact" value="Avant 12h00">
            <label for="avant12h">Avant 12h00</label><br>
            <input type="radio" id="entre12h14h" name="contact" value="Entre 12h00 et 14h00">
            <label for="entre12h14h">Entre 12h00 et 14h00</label><br>
            <input type="radio" id="entre14h18h" name="contact" value="Entre 14h00 et 18h00">
            <label for="entre14h18h">Entre 14h00 et 18h00</label><br>
            <input type="radio" id="apres18h" name="contact" value="Après 18h00">
            <label for="apres18h">Après 18h00</label>
        </div>

        <div class="form-group">
            <label> Ajoutez une description à votre bien !<span class="obligatoire">
                    (obligatoire)</span></label><br>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="form-group">
            <input type="checkbox" id="acceptation" name="acceptation">
            <label for="acceptation">Pour soumettre ce formulaire, vous devez accepter notre Déclaration de
                confidentialité.<span class="obligatoire">
                    (obligatoire)</span></label><br>
            <a href="#">Déclaration de confidentialité</a>
        </div>

        <div class="g-recaptcha" data-sitekey="6Ldc0AUqAAAAAEDHoRI7yEwkGApoK36A9JbqJjOg"
            data-callback="validateCaptcha">
        </div>

        <button id="submitButton" type="submit" onclick="return validateCaptcha()">RECEVOIR MON ETUDE DE
            RENTABILITE</button>



</form>

<script>
    function validateForm() {
        event.preventDefault();

        var token = "<?php echo $_SESSION['token']; ?>";

        var adresse = document.getElementById('adresse').value;
        var ville = document.getElementById('ville').value;
        var codePostal = document.getElementById('codePostal').value;

        var adresseComplete = adresse + ", " + codePostal + " " + ville;

        validateAddress(adresseComplete, function (isValid) {
            if (isValid) {
                var token = "<?php echo $_SESSION['token']; ?>";

                var formData = {
                    token: token,
                    conciergerie: document.querySelector('input[name="conciergerie"]:checked').value,
                    autreConciergerie: document.getElementById('autreConciergerie').value,
                    adresse: adresseComplete,
                    pays: document.getElementById('pays').value,
                    typeBien: document.getElementById('typeBien').value,
                    typeLocation: document.getElementById('typeLocation').value,
                    superficie: document.getElementById('superficie').value,
                    nombreChambres: document.getElementById('nombreChambres').value,
                    capacite: document.getElementById('capacite').value,
                    nom: document.getElementById('nom').value,
                    email: document.getElementById('email').value,
                    telephone: document.getElementById('telephone').value,
                    contact: document.querySelector('input[name="contact"]:checked').value,
                    acceptation: document.getElementById('acceptation').checked,
                    description: document.getElementById('description').value
                };

                if (validateFormData(formData)) {
                    sendFormDataToAPI(formData);
                }

                if (!validateFormData(formData)) {
                    return false;
                }


                return false;

            } else {
                alert('Adresse invalide. Veuillez entrer une adresse valide.');
            }
        });

    }

    function validateFormData(formData) {

        if (formData.conciergerie.trim() === '') {
            alert('Veuillez sélectionner un type de conciergerie.');
            return false;
        }

        if (formData.adresse.trim() === '') {
            alert('Veuillez entrer une adresse.');
            return false;
        }
        if (formData.adresse.trim() === '') {
            alert('Veuillez entrer une adresse.');
            return false;
        }

        if (formData.pays.trim() === '') {
            alert('Veuillez sélectionner un pays.');
            return false;
        }

        if (formData.typeBien.trim() === '') {
            alert('Veuillez sélectionner un type de bien.');
            return false;
        }

        if (formData.typeLocation.trim() === '') {
            alert('Veuillez sélectionner un type de location.');
            return false;
        }

        if (formData.superficie.trim() === '') {
            alert('Veuillez entrer une superficie.');
            return false;
        }

        if (formData.nombreChambres.trim() === '') {
            alert('Veuillez entrer un nombre de chambres.');
            return false;
        }

        if (formData.capacite.trim() === '') {
            alert('Veuillez sélectionner une capacité.');
            return false;
        }

        if (formData.nom.trim() === '') {
            alert('Veuillez entrer un nom.');
            return false;
        }

        if (formData.email.trim() === '') {
            alert('Veuillez entrer un email.');
            return false;
        }

        if (formData.telephone.trim() === '') {
            alert('Veuillez entrer un numéro de téléphone.');
            return false;
        }

        if (formData.contact.trim() === '') {
            alert('Veuillez sélectionner une heure de contact.');
            return false;
        }

        if (!formData.acceptation) {
            alert('Veuillez accepter la déclaration de confidentialité.');
            return false;
        }

        if (formData.description.trim() === '') {
            alert('Veuillez entrer une description.');
            return false;
        }


        return true;
    }

    function sendFormDataToAPI(formData) {

        var xhr = new XMLHttpRequest();
        var url = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/demandebiens';
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                console.log(xhr.responseText);
                if (xhr.status === 200) {
                    console.log(formData);

                    alert('Votre demande a été soumise avec succès !');

                    window.location.href = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/Site/index.php';
                } else {

                    alert('Une erreur s\'est produite. Veuillez réessayer plus tard.');
                    console.log(xhr.responseText);
                }
            }
        };
        xhr.send(JSON.stringify(formData));
    }

    function validateAddress(address, callback) {
        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status === 'OK') {
                callback(true);
            } else {
                callback(false);
            }
        });
    }
</script>