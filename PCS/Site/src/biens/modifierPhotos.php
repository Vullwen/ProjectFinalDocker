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
        </div>
        <button type='submit' class='btn btn-primary'>Enregistrer les modifications</button>
    </form>
</div>

<script>
    document.getElementById('photoForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(document.getElementById('photoForm'));


        var photosToDelete = [];
        formData.querySelectorAll('input[name="photosToDelete[]"]:checked').forEach(function (checkbox) {
            photosToDelete.push(checkbox.value);
        });

        if (photosToDelete.length > 0) {
            formData.append('photosToDelete', JSON.stringify(photosToDelete));
        }
        console.log(formData);

        var xhr = new XMLHttpRequest();
        xhr.open('PATCH', 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/photos' + <?= json_encode($idBien) ?>, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Modifications enregistrées avec succès.');
                    window.location.reload();
                } else {
                    alert('Erreur lors de l\'enregistrement des modifications : ' + (response.message || 'Erreur inconnue'));
                }
            } else {
                alert('Une erreur s\'est produite lors de l\'enregistrement des modifications.');
            }
        };
        xhr.send(formData);
    });
</script>

<?php
include_once "../../template/footer.php";
?>