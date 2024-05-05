<?php

require_once '../../../Site/template/header.php';
require_once '../../../API/database/connectDB.php';

if (isset($_GET['id'])) {

    $bienId = $_GET['id'];

    $db = connectDB();

    $query = $db->prepare("SELECT bienimmobilier.*, utilisateur.nom, utilisateur.prenom, utilisateur.telephone FROM bienimmobilier 
                            INNER JOIN utilisateur ON bienimmobilier.idutilisateur = utilisateur.idutilisateur 
                            WHERE IDbien = :bienId");
    $query->execute(['bienId' => $bienId]);
    $bien = $query->fetch(PDO::FETCH_ASSOC);

    $photosQuery = $db->prepare("SELECT cheminPhoto FROM photobienimmobilier WHERE IDbien = :bienId");
    $photosQuery->execute(['bienId' => $bienId]);
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
        echo "<p><strong>Propriétaire:</strong> {$bien['nom']} {$bien['prenom']} (Téléphone: {$bien['telephone']})</p>";

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
    } else {
        echo "<div class='container mt-5'>";
        echo "<p>Le bien immobilier demandé n'existe pas.</p>";
        echo "</div>";
    }
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Aucun ID de bien n'a été fourni.</p>";
    echo "</div>";
}
