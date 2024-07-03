<?php
include_once "../../template/header.php";

$idBien = $_GET['id'];

function getPhotosBien($id)
{
    $url = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/demandesBiens/photos";
    $params = ['idBien' => $id];
    $queryString = http_build_query($params);
    $url .= '?' . $queryString;

    $response = file_get_contents($url);
    return json_decode($response, true);
}
$photos = getPhotosBien($idBien);
?>

<div class='container mt-5'>
    <h2>Gestion des Photos pour le Bien Immobilier</h2>
    <form id='photoForm' enctype='multipart/form-data'>
        <div class='form-group'>
            <label>Photos Actuelles</label>
            <?php
            if (!empty($photos['photos'])) {
                foreach ($photos['photos'] as $photo) {
                    $photoUrl = "/2A-ProjetAnnuel/PCS/Site/" . $photo['cheminPhoto'];
                    echo "<div class='photo-container'>";
                    echo "<img src='{$photoUrl}' class='img-thumbnail' width='150'>";
                    echo "<label><input type='checkbox' name='photosToDelete[]' value='{$photo['cheminPhoto']}'> Supprimer</label>";
                    echo "</div>";
                }
            } else {
                echo "<p>Aucune photo disponible pour ce bien immobilier.</p>";
            }
            ?>
        </div>
        <div class='form-group'>
            <label for='photos'>Ajouter de Nouvelles Photos</label>
            <input type='file' class='form-control-file' id='photos' name='photos[]' accept='image/*' multiple>
            <div id="photoPreview"></div>


        </div>
        <button type='submit' class='btn btn-primary'>Enregistrer les modifications</button>
    </form>
</div>

<script>
    document.getElementById('photos').addEventListener('change', function (event) {
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

    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('photoForm');

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var formData = new FormData(form);

            var checkboxes = document.querySelectorAll('input[name="photosToDelete[]"]:checked');
            var photosToDelete = [];
            checkboxes.forEach(function (checkbox) {
                photosToDelete.push(checkbox.value);
            });

            var idBien = <?= json_encode($idBien) ?>;

            var photosToAdd = document.getElementById('photos').files;
            if (photosToAdd.length === 0 && photosToDelete.length === 0) {
                alert('Aucune modification à enregistrer.');
                return;
            }

            if (photosToDelete.length > 0) {
                fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/photos?id=' + idBien, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ photosToDelete: photosToDelete })
                })
                    .then(function (response) {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Erreur lors de la suppression des photos.');
                    })
                    .then(function (data) {
                        console.log('Suppression des photos réussie :', data);
                        window.location.reload();
                    })
                    .catch(function (error) {
                        console.error('Erreur lors de la requête de suppression :', error);
                    });
            }

            if (photosToAdd.length > 0) {
                fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/photos?id=' + idBien, {
                    method: 'POST',
                    body: formData
                })
                    .then(function (response) {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Erreur lors de l\'ajout des nouvelles photos.');
                    })
                    .then(function (data) {
                        console.log('Ajout des nouvelles photos réussi :', data);
                        window.location.reload();
                    })
                    .catch(function (error) {
                        console.error('Erreur lors de la requête d\'ajout :', error);
                    });
            }
        });
    });


</script>

<?php
include_once "../../template/footer.php";
?>