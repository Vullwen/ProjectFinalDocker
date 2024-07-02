<?php
include "../../../Site/template/header.php";

$apiUrl = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/demandebiens?id=' . $_GET['id'];

$response = file_get_contents($apiUrl);


if ($response === FALSE) {
    die("L'appel à l'API a échoué.");
}

$responseData = json_decode($response, true);

if (!$responseData || !$responseData['success']) {
    die("Aucune demande de bailleur n'a été trouvée ou une erreur s'est produite.");
}

$demande = $responseData['data'];
$demande += ['tarif' => $_GET['tarif']];

var_dump($demande);
// Appel API a l'url http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens en method POST et ranger 