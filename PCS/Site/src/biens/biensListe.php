<?php


if (!$SESSION['estBailleur'] = 1) {
    header("Location: /2A-ProjetAnnuel/PCS/Site/src/login.php");
}

include_once "../../template/header.php";
include_once "../../../API/database/connectDB.php";



$db = connectDB();

$query = $db->prepare("SELECT idutilisateur FROM utilisateur WHERE token = :token");
$query->execute(['token' => $_SESSION['token']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $idutilisateur = $user['idutilisateur'];

    $biensQuery = $db->prepare("SELECT * FROM bienimmobilier WHERE idutilisateur = :idutilisateur");
    $biensQuery->execute(['idutilisateur' => $idutilisateur]);
    $biens = $biensQuery->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($biens)) {
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
        foreach ($biens as $bien) {
            echo "<tr>";
            echo "<td>{$bien['Type']}</td>";
            echo "<td>{$bien['Adresse']}</td>";
            echo "<td>{$bien['Description']}</td>";
            echo "<td>{$bien['Superficie']}</td>";
            echo "<td>{$bien['NbChambres']}</td>";
            echo "<td>{$bien['Tarif']} € / nuit</td>";
            echo "<td><a href='/2A-ProjetAnnuel/PCS/Site/src/biens/details_bien.php?id={$bien['IDBien']}' class='btn btn-primary'>Détails</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'>";
        echo "<p>Vous n'avez pas encore ajouté de bien immobilier.</p>";
        echo "</div>";
    }
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Une erreur s'est produite lors de la récupération de vos biens immobiliers.</p>";
    echo "</div>";
}

include_once "../../template/footer.php";
