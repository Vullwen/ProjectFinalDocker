<?php

include_once "../../template/header.php";
include_once "../../../API/database/connectDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement du formulaire après soumission
    $type = $_POST['type'];
    $adresse = $_POST['adresse'];
    $description = $_POST['description'];
    $superficie = $_POST['superficie'];
    $nbChambres = $_POST['nbChambres'];
    $tarif = $_POST['tarif'];
    $token = $_SESSION['token'];  // Assurez-vous que le token est stocké dans la session

    // Récupérer l'ID de l'utilisateur à partir du token
    $db = connectDB();
    $userQuery = $db->prepare("SELECT IDUtilisateur FROM utilisateur WHERE token = :token");
    $userQuery->execute(['token' => $token]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $idUtilisateur = $user['IDUtilisateur'];

        // Insérer le nouveau bien immobilier
        $insertQuery = $db->prepare("INSERT INTO bienimmobilier (IDUtilisateur, Type, Adresse, Description, Superficie, NbChambres, Tarif) VALUES (:IDUtilisateur, :type, :adresse, :description, :superficie, :nbChambres, :tarif)");
        $insertQuery->execute([
            'IDUtilisateur' => $idUtilisateur,
            'type' => $type,
            'adresse' => $adresse,
            'description' => $description,
            'superficie' => $superficie,
            'nbChambres' => $nbChambres,
            'tarif' => $tarif
        ]);

        echo "<div class='container mt-5'>";
        echo "<p>Le bien immobilier a été ajouté avec succès.</p>";
        echo "<a href='details_bien.php?id={$db->lastInsertId()}' class='btn btn-primary'>Voir le bien</a>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'>";
        echo "<p>Erreur : utilisateur non trouvé.</p>";
        echo "</div>";
    }
} else {
    // Afficher le formulaire d'ajout
    echo "<div class='container mt-5'>";
    echo "<h2>Ajouter un Nouveau Bien Immobilier</h2>";
    echo "<form action='ajouterBien.php' method='POST'>";
    echo "<div class='form-group'>";
    echo "<label for='type'>Type<span class='obligatoire'>
    (obligatoire)</span></label>";
    echo "<input type='text' class='form-control' id='type' name='type' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='adresse'>Adresse<span class='obligatoire'>
    (obligatoire)</span></label>";
    echo "<input type='text' class='form-control' id='adresse' name='adresse' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='description'>Description<span class='obligatoire'>
    (obligatoire)</span></label>";
    echo "<textarea class='form-control' id='description' name='description' rows='3' required></textarea>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='superficie'>Superficie<span class='obligatoire'>
    (obligatoire)</span></label>";
    echo "<input type='number' class='form-control' id='superficie' name='superficie' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='nbChambres'>Nombre de Chambres<span class='obligatoire'>
    (obligatoire)</span></label>";
    echo "<input type='number' class='form-control' id='nbChambres' name='nbChambres' required>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='tarif'>Tarif (€ / nuit)<span class='obligatoire'>
    (obligatoire)</span></label>";
    echo "<input type='number' class='form-control' id='tarif' name='tarif' required>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Ajouter le Bien</button>";
    echo "</form>";
    echo "</div>";
}

include_once "../../template/footer.php";

