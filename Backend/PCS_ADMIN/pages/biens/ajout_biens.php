<?php
include "../../../Site/template/header.php";

if (isAdmin()) {
    echo '<div class="container">
        <h1>Ajout d\'un bien Immobilier</h1>
        <form id="ajoutbien" enctype="multipart/form-data">
            <div class="form-group">
                <label for="type">Type de bien</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="superficie">Superficie</label>
            <input type="number" class="form-control" id="superficie" name="superficie" required>
        </div>
        <div class="form-group">
            <label for="nbchambres">Nombre de chambres</label>
            <input type="number" class="form-control" id="nbchambres" name="nbchambres" required>
        </div>
        <div class="form-group">
            <label for="tarif">Tarif à la nuitée</label>
            <input type="number" class="form-control" id="tarif" name="tarif" required>
        </div>
        <div class="form-group">
    <label for="bailleur">Propriétaire</label>
    <select class="form-control" id="bailleur" name="bailleur">
        <option value="">Sélectionnez un propriétaire</option>

    </select>
</div>
            <div class="form-group">
                <label for="photos">Photos</label>
                <input type="file" class="form-control" id="photos" name="photos[]" multiple required>
                <div id="imagePreview"></div> 
            </div>
            <input type="submit" value="Ajouter le bien">
        </form>
    </div>';
} else {
    echo '<div class="container">
        <h1>Ajout d\'un bien</h1>
        <p>Vous n\'avez pas les droits pour accéder à cette page</p>';
}
?>
<a href="../../index.php" class="btn btn-primary">Retour au menu Admin</a>

<script>
    document.getElementById('photos').addEventListener('change', function () {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        Array.from(this.files).forEach(file => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '400px';
                img.style.marginRight = '30px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    });
</script>

<script>
    // Code Javascript pour traduire le formulaire en JSON envoi API
    document.getElementById('ajoutbien').addEventListener('submit', function (event) {
        event.preventDefault();

        var bailleurSelect = document.getElementById('bailleur');
        var selectedBailleurIndex = bailleurSelect.selectedIndex;
        var bailleurId = bailleurSelect.options[selectedBailleurIndex].value;

        var files = document.getElementById('photos').files;
        var photoNames = [];


        for (var i = 0; i < files.length; i++) {
            var uniqueFileName = generateUniqueFileName(files[i].name);
            photoNames.push(uniqueFileName);
        }

        function generateUniqueFileName(fileName) {

            var timestamp = new Date().getTime();

            var uniqueFileName = timestamp + '_' + fileName;
            return uniqueFileName;
        }


        var formData = {
            type: document.getElementById('type').value,
            adresse: document.getElementById('adresse').value,
            description: document.getElementById('description').value,
            superficie: document.getElementById('superficie').value,
            nbchambres: document.getElementById('nbchambres').value,
            tarif: document.getElementById('tarif').value,
            idutilisateur: bailleurId,
            photos: photoNames,
        }




        console.log(photoNames);

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })

            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.message);

                } else {
                    alert('Bien ajouté avec succès');
                    //window.location.href = 'bien.php';  // ICI FAUT REPRENDRE 
                }
            });
    });

</script>

<script>
    // Code JS pour récuperer bailleurs et mettre dans la liste déroulante
    fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/bailleurs')
        .then(response => response.json())
        .then(data => {
            const bailleurSelect = document.getElementById('bailleur');

            data.forEach(bailleur => {
                const option = document.createElement('option');
                option.value = bailleur.idutilisateur;
                option.textContent = bailleur.nom + ' ' + bailleur.prenom;
                bailleurSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des bailleurs:', error);
        });
</script>