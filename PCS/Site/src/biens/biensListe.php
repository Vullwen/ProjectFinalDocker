<?php

if (!$SESSION['estBailleur'] = 1) {
    header("Location: /2A-ProjetAnnuel/PCS/Site/src/login.php");
}

include_once "../../template/header.php";
include_once "../../functions/callApi.php";

$token = $_SESSION['token'];
$apiUrlUser = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id";
$headers = array(
    "Authorization: Bearer $token"
);

$responseUser = callAPI('GET', $apiUrlUser, false, $headers);
$userData = json_decode($responseUser, true);

if (!$userData || !isset($userData['idutilisateur'])) {
    echo "<div class='container mt-5'>";
    echo "<p>Une erreur s'est produite lors de la récupération de l'utilisateur.</p>";
    echo "</div>";
    include_once "../../template/footer.php";
    exit;
}

$idutilisateur = $userData['idutilisateur'];

$apiUrlBiens = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens/listeBiensProprietaires?id=$idutilisateur";
$responseBiens = callAPI('GET', $apiUrlBiens);
$biensData = json_decode($responseBiens, true);

if ($biensData && !empty($biensData)) {
    echo "<div class='container mt-5'>";
    echo "<h2>Liste de vos biens immobiliers</h2>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col'>Type</th>";
    echo "<th scope='col'>Adresse</th>";
    echo "<th scope='col'>Description</th>";
    echo "<th scope='col'>Superficie</th>";
    echo "<th scope='col'>Nombre de chambres</th>";
    echo "<th scope='col'>Tarif</th>";
    echo "<th scope='col'>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($biensData as $bien) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($bien['Type_bien']) . "</td>";
        echo "<td>" . htmlspecialchars($bien['Adresse']) . "</td>";
        echo "<td>" . htmlspecialchars($bien['Description']) . "</td>";
        echo "<td>" . htmlspecialchars($bien['Superficie']) . "</td>";
        echo "<td>" . htmlspecialchars($bien['NbChambres']) . "</td>";
        echo "<td>" . htmlspecialchars($bien['Tarif']) . " € / nuit</td>";
        echo "<td><a href='/2A-ProjetAnnuel/PCS/Site/src/biens/details_bien.php?id=" . htmlspecialchars($bien['IDBien']) . "' class='btn btn-primary'>Détails</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo '<div class="container mt-2 btn-center">
        <a class="btn btn-primary" href="/2A-ProjetAnnuel/PCS/Site/src/biens/ajoutBiens.php">Ajouter un bien</a>
        </div>';
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Vous n'avez pas encore ajouté de bien immobilier.</p>";
    echo "</div>";
}

include_once "../../template/footer.php";