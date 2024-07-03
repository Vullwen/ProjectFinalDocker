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
    <form action='gestionPhotos.php?id=<?= $idBien ?>' method='POST' enctype='multipart/form-data'>
        <div class='form-group'>
            <label>Photos Actuelles</label>
            <?php
            if (!empty($photos['photos'])) {
                foreach ($photos['photos'] as $photo) {
                    $photoUrl = "/2A-ProjetAnnuel/PCS/Site/" . $photo['cheminPhoto'];
                    echo "<img src='{$photoUrl}' class='img-thumbnail' width='150'>";
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
        <button type='submit' class='btn btn-primary'>Télécharger les photos</button>
    </form>
</div>

<?php
include_once "../../template/footer.php";
?>