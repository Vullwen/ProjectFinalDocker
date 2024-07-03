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

        var formData = new FormData(this);


        var photosToDelete = [];
        var checkboxes = document.querySelectorAll('input[name="photosToDelete[]"]:checked');
        checkboxes.forEach(function (checkbox) {
            photosToDelete.push(checkbox.value);
        });

        var data = {
            photosToDelete: photosToDelete
        };
        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/photos?id=' + <?= json_encode($idBien) ?>, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(function (jsonResponse) {
                console.log(jsonResponse);
                if (jsonResponse.success) {
                    alert('Modifications enregistrées avec succès.');
                    window.location.reload();
                } else {
                    alert('Erreur lors de l\'enregistrement des modifications : ' + (jsonResponse.message || 'Erreur inconnue'));
                }
            })
            .catch(function (error) {
                console.error('Erreur lors de la requête fetch:', error);
                alert('Une erreur s\'est produite lors de l\'enregistrement des modifications.');
            });
    });

</script>

<?php
include_once "../../template/footer.php";
?>