<?php

include_once "../../template/header.php";
include_once "../../../API/database/connectDB.php";


$db = connectDB();

$dbquery = $db->prepare("SELECT * FROM bienimmobilier WHERE IDBien = :IDBien");
$dbquery->execute(['IDBien' => $_GET['id']]);
$bien = $dbquery->fetch(PDO::FETCH_ASSOC);

$photosQuery = $db->prepare("SELECT cheminPhoto FROM photobienimmobilier WHERE IDBien = :IDBien");
$photosQuery->execute(['IDBien' => $_GET['id']]);
$photos = $photosQuery->fetchAll(PDO::FETCH_ASSOC);

if ($bien) {
    echo "<div class='container mt-5'>";
    echo "<h2>Détails du Bien Immobilier</h2>";
    echo "<p><strong>Type:</strong> {$bien['Type']}</p>";
    echo "<p><strong>Adresse:</strong> {$bien['Adresse']}</p>";
    echo "<p><strong>Description:</strong> {$bien['Description']}</p>";
    echo "<p><strong>Superficie:</strong> {$bien['Superficie']}</p>";
    echo "<p><strong>Nombre de Chambres:</strong> {$bien['NbChambres']}</p>";
    echo "<p><strong>Tarif:</strong> {$bien['Tarif']} € / nuit</p>";

    // Afficher les photos du bien
    if (!empty($photos)) {
        echo "<h3>Photos</h3>";
        echo "<div class='row'>";
        foreach ($photos as $photo) {
            echo "<div class='col-md-4 mb-4'>";
            echo "<img src='https://localhost/2A-ProjetAnnuel/PCS/Site/img/photosBI/{$photo['cheminPhoto']}' class='img-fluid' alt='Photo'>";
            echo "</div>";
        }
        echo "</div>";

    }

    echo "</div>";

    echo "<a href='modifierBiens.php?id={$bien['IDBien']}' class='btn btn-primary'>Modifier</a>";
    echo "<a href='supprimerBiens.php?id={$bien['IDBien']}' class='btn btn-danger'>Supprimer</a>";
    echo "<a href='biensListe.php' class='btn btn-secondary'>Retour à la liste</a>";
    echo "<a href='details_reservation.php?id={$bien['IDBien']}' class='btn btn-primary'>Voir les réservations</a>";

} else {
    echo "<div class='container mt-5'>";
    echo "<p>Le bien immobilier demandé n'existe pas.</p>";
    echo "</div>";
}
