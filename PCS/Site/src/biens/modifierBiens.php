<?php
include_once "../../template/header.php";

$idBien = $_GET['id'];


function getBienDetails($id)
{
    $url = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens?id={$id}";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function getPhotosBien($id)
{
    $url = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/demandesBiens/photos";
    $params = ['idBien' => $id];
    $queryString = http_build_query($params);
    $url .= '?' . $queryString;

    $response = file_get_contents($url);
    return json_decode($response, true);
}

function updateBien($id, $data)
{
    $url = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens?id={$id}";
    $options = [
        'http' => [
            'method' => 'PATCH',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idBien = $_POST['id'];
    $type = $_POST['type_bien'];
    $adresse = $_POST['adresse'];
    $description = $_POST['description'];
    $superficie = $_POST['superficie'];
    $nbChambres = $_POST['nbChambres'];

    $data = [
        'Type_bien' => $type,
        'Adresse' => $adresse,
        'Description' => $description,
        'Superficie' => $superficie,
        'NbChambres' => $nbChambres
    ];

    $bienActuel = getBienDetails($idBien);
    if ($bienActuel) {
        $bienActuel = $bienActuel['properties'][0];

        $dataDiff = array_diff_assoc($data, $bienActuel);
        if (empty($dataDiff)) {
            echo "<div class='container mt-5'>";
            echo "<p>Aucune modification détectée. Veuillez apporter des modifications avant de soumettre.</p>";
            echo "</div>";
        } else {
            $updateResponse = updateBien($idBien, $dataDiff);

            var_dump($updateResponse);

            if (isset($updateResponse['success']) && $updateResponse['success']) {
                header("Location: biensListe.php");
                exit;
            } else {
                echo "<div class='container mt-5'>";
                echo "<p>Erreur lors de la mise à jour du bien immobilier : " . ($updateResponse['message'] ?? 'Erreur inconnue') . "</p>";
                echo "</div>";
            }
        }
    } else {
        echo "<div class='container mt-5'>";
        echo "<p>Erreur lors de la récupération des détails actuels du bien immobilier.</p>";
        echo "</div>";
    }
} else if (!isset($idBien)) {
    echo "<div class='container mt-5'>";
    echo "<p>Formulaire incomplet : tous les champs sont requis.</p>";
    echo "</div>";
} else {
    $bien = getBienDetails($idBien);
    $photos = getPhotosBien($idBien);

    if ($bien && $photos) {
        echo "<div class='container mt-5'>";
        echo "<h2>Modifier le Bien Immobilier</h2>";
        echo "<form action='modifierBiens.php' method='POST'>";
        echo "<input type='hidden' name='id' value='{$bien['properties']['IDBien']}'>";
        echo "<div class='form-group'>";
        echo "<label for='type'>Type</label>";
        echo "<input type='text' class='form-control' id='type' name='type_bien' value='{$bien['properties'][0]['Type_bien']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='adresse'>Adresse</label>";
        echo "<input type='text' class='form-control' id='adresse' name='adresse' value='{$bien['properties'][0]['Adresse']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='description'>Description</label>";
        echo "<textarea class='form-control' id='description' name='description' rows='3' required>{$bien['properties'][0]['Description']}</textarea>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='superficie'>Superficie</label>";
        echo "<input type='number' class='form-control' id='superficie' name='superficie' value='{$bien['properties'][0]['Superficie']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='nbChambres'>Nombre de Chambres</label>";
        echo "<input type='number' class='form-control' id='nbChambres' name='nbChambres' value='{$bien['properties'][0]['NbChambres']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label>Photos Actuelles</label>";
        if (!empty($photos['photos'])) {
            foreach ($photos['photos'] as $photo) {
                $photoUrl = "/2A-ProjetAnnuel/PCS/Site/" . $photo['cheminPhoto'];
                echo "<img src='{$photoUrl}' class='img-thumbnail' width='150'>";
            }
        } else {
            echo "<p>Aucune photo disponible pour ce bien immobilier.</p>";
        }
        echo "</div>";

        echo "<div class='form-group'>";
        echo "<label for='photos'>Ajouter de Nouvelles Photos</label>";
        echo "<input type='file' class='form-control-file' id='photos' name='photos[]' accept='image/*' multiple>";
        echo "</div>";
        echo "<button type='submit' class='btn btn-primary'>Enregistrer les modifications</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'>";
        echo "<p>Le bien immobilier demandé n'existe pas.</p>";
        echo "</div>";
    }
}

include_once "../../template/footer.php";