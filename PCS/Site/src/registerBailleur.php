<?php

include_once '../template/header.php';
?>


<h1 id="titleFormBailleur"> Devenir Bailleur chez ParisCareTaker ! </h1>

<form id="devenirBailleurForm" onsubmit="validateForm()" enctype="multipart/form-data">
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
            <label for="propertyPhotos">Photos de votre bien immobilier :</label><br>
            <input type="file" id="propertyPhotos" name="propertyPhotos[]" multiple required>
            <div id="photoPreview"></div>
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

        <div class="g-recaptcha" data-sitekey="6Ld40AUqAAAAADd717WRZdloLksS3rEQzeojjiqf"
            data-callback="validateCaptcha">
        </div>

        <button id="submitButton" type="submit" onclick="return validateCaptcha()">RECEVOIR MON ETUDE DE
            RENTABILITE</button>



</form>

<script>
    document.getElementById('propertyPhotos').addEventListener('change', function (event) {
        var files = event.target.files;
        var photoPreview = document.getElementById('photoPreview');
        photoPreview.innerHTML = '';

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '200px';
                img.style.margin = '10px';
                photoPreview.appendChild(img);
            };

            reader.readAsDataURL(file);
        }
    });


    function validateCaptcha() {
        var response = grecaptcha.getResponse();
        if (response.length === 0) {
            alert('Veuillez valider le captcha.');
            return false;
        }
        return true;
    }
    function validateForm(event) {
        event.preventDefault();

        var token = "<?php echo $_SESSION['token']; ?>";

        var adresse = document.getElementById('adresse').value;
        var ville = document.getElementById('ville').value;
        var codePostal = document.getElementById('codePostal').value;

        var adresseComplete = adresse + ", " + codePostal + " " + ville;

        validateAddress(adresseComplete, function (isValid) {
            if (isValid) {
                var formData = new FormData();
                formData.append('token', token);
                formData.append('conciergerie', document.querySelector('input[name="conciergerie"]:checked').value);
                formData.append('autreConciergerie', document.getElementById('autreConciergerie').value);
                formData.append('adresse', adresseComplete);
                formData.append('pays', document.getElementById('pays').value);
                formData.append('typeBien', document.getElementById('typeBien').value);
                formData.append('typeLocation', document.getElementById('typeLocation').value);
                formData.append('superficie', document.getElementById('superficie').value);
                formData.append('nombreChambres', document.getElementById('nombreChambres').value);
                formData.append('capacite', document.getElementById('capacite').value);
                formData.append('nom', document.getElementById('nom').value);
                formData.append('email', document.getElementById('email').value);
                formData.append('telephone', document.getElementById('telephone').value);
                formData.append('contact', document.querySelector('input[name="contact"]:checked').value);
                formData.append('acceptation', document.getElementById('acceptation').checked);
                formData.append('description', document.getElementById('description').value);

                var photoFiles = document.getElementById('propertyPhotos').files;
                for (var i = 0; i < photoFiles.length; i++) {
                    formData.append('propertyPhotos[]', photoFiles[i]);
                }
                console.log(formData.get('conciergerie'));
                console.log(formData.get('autreConciergerie'));
                console.log(formData.get('adresse'));
                console.log(formData.get('pays'));
                console.log(formData.get('typeBien'));
                console.log(formData.get('typeLocation'));
                console.log(formData.get('superficie'));
                console.log(validateFormData(formData));

                if (validateFormData(formData)) {
                    sendFormDataToAPI(formData);
                } else {
                    return false;
                }

            } else {
                alert('Adresse invalide. Veuillez entrer une adresse valide.');
            }
        });

    }

    function validateFormData(formData) {
        if (!formData.get('conciergerie')) {
            alert('Veuillez sélectionner un type de conciergerie.');
            return false;
        }

        if (!formData.get('adresse')) {
            alert('Veuillez entrer une adresse.');
            return false;
        }

        if (!formData.get('pays')) {
            alert('Veuillez entrer un pays.');
            return false;
        }

        if (!formData.get('typeBien')) {
            alert('Veuillez entrer un type de bien.');
            return false;
        }

        if (!formData.get('typeLocation')) {
            alert('Veuillez entrer un type de location.');
            return false;
        }

        if (!formData.get('superficie')) {
            alert('Veuillez entrer une superficie.');
            return false;
        }

        if (!formData.get('nombreChambres')) {
            alert('Veuillez entrer le nombre de chambres.');
            return false;
        }

        if (!formData.get('capacite')) {
            alert('Veuillez entrer la capacité.');
            return false;
        }

        if (!formData.get('nom')) {
            alert('Veuillez entrer un nom.');
            return false;
        }

        if (!formData.get('email')) {
            alert('Veuillez entrer un email.');
            return false;
        }

        if (!formData.get('telephone')) {
            alert('Veuillez entrer un numéro de téléphone.');
            return false;
        }

        if (!formData.get('contact')) {
            alert('Veuillez sélectionner un type de contact.');
            return false;
        }

        if (!formData.get('acceptation')) {
            alert('Vous devez accepter les termes et conditions.');
            return false;
        }

        if (!formData.get('description')) {
            alert('Veuillez entrer une description.');
            return false;
        }

        return true;
    }

    function sendFormDataToAPI(formData) {

        var xhr = new XMLHttpRequest();
        var url = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/demandebiens';
        xhr.open('POST', url, true);
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
        xhr.send(formData);
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