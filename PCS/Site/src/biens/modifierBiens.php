<?php

include_once "../../template/header.php";
include_once "../../../API/database/connectDB.php";

$db = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement du formulaire après soumission
    $idBien = $_POST['id'];
    $type = $_POST['type'];
    $adresse = $_POST['adresse'];
    $description = $_POST['description'];
    $superficie = $_POST['superficie'];
    $nbChambres = $_POST['nbChambres'];
    $tarif = $_POST['tarif'];

    // Mettre à jour les informations du bien immobilier
    $updateQuery = $db->prepare("UPDATE bienimmobilier SET Type = :type, Adresse = :adresse, Description = :description, Superficie = :superficie, NbChambres = :nbChambres, Tarif = :tarif WHERE IDBien = :idBien");
    $updateQuery->execute([
        'type' => $type,
        'adresse' => $adresse,
        'description' => $description,
        'superficie' => $superficie,
        'nbChambres' => $nbChambres,
        'tarif' => $tarif,
        'idBien' => $idBien
    ]);

    echo "<div class='container mt-5'>";
    echo "<p>Les informations du bien immobilier ont été mises à jour avec succès.</p>";
    echo "<a href='details_bien.php?id={$idBien}' class='btn btn-primary'>Retour aux détails</a>";
    echo "</div>";
} else {
    // Afficher le formulaire avec les données actuelles du bien
    $idBien = $_GET['id'];

    $dbquery = $db->prepare("SELECT * FROM bienimmobilier WHERE IDBien = :IDBien");
    $dbquery->execute(['IDBien' => $idBien]);
    $bien = $dbquery->fetch(PDO::FETCH_ASSOC);

    if ($bien) {
        echo "<div class='container mt-5'>";
        echo "<h2>Modifier le Bien Immobilier</h2>";
        echo "<form action='modifierBiens.php' method='POST'>";
        echo "<input type='hidden' name='id' value='{$bien['IDBien']}'>";
        echo "<div class='form-group'>";
        echo "<label for='type'>Type</label>";
        echo "<input type='text' class='form-control' id='type' name='type' value='{$bien['Type']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='adresse'>Adresse</label>";
        echo "<input type='text' class='form-control' id='adresse' name='adresse' value='{$bien['Adresse']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='description'>Description</label>";
        echo "<textarea class='form-control' id='description' name='description' rows='3' required>{$bien['Description']}</textarea>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='superficie'>Superficie</label>";
        echo "<input type='number' class='form-control' id='superficie' name='superficie' value='{$bien['Superficie']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='nbChambres'>Nombre de Chambres</label>";
        echo "<input type='number' class='form-control' id='nbChambres' name='nbChambres' value='{$bien['NbChambres']}' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='tarif'>Tarif (€ / nuit)</label>";
        echo "<input type='number' class='form-control' id='tarif' name='tarif' value='{$bien['Tarif']}' required>";
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
