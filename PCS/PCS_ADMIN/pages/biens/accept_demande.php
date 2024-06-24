<?php
include_once '../../../Site/template/header.php';
include_once '../../../API/database/connectDB.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("L'identifiant de la demande est obligatoire.");
} else if (!isset($_SESSION['isAdmin'])) {
    die("Vous n'êtes pas autorisé à accéder à cette page.");
}

$db = connectDB();

if (!$db) {
    die("La connexion à la base de données a échoué.");
}

$idDemande = $_GET['id'];

$getDemandeQuery = $db->prepare("SELECT * FROM demandebailleurs WHERE id = :id");
$getDemandeQuery->execute(['id' => $idDemande]);
$demande = $getDemandeQuery->fetch(PDO::FETCH_ASSOC);


if ($demande) {

    if (($demande['type_conciergerie'] == "Autre")) {
        $type_conciergerie = $demande['autre_conciergerie'];
    } else {
        $type_conciergerie = null;
    }

    $insertQuery = $db->prepare("
        INSERT INTO bienimmobilier 
        (adresse, type_bien, description, superficie, nbchambres, tarif, type_conciergerie, idutilisateur, pays, type_location, capacite)
        VALUES 
        (:adresse, :type_bien, :description, :superficie, :nbchambres, :tarif, :type_conciergerie, :idutilisateur, :pays, :type_location, :capacite)
    ");

    $result = $insertQuery->execute([
        'adresse' => $demande['adresse'],
        'type_bien' => $demande['type_bien'],
        'description' => $demande['description'],
        'superficie' => $demande['superficie'],
        'nbchambres' => $demande['nombre_chambres'],
        'tarif' => 55, // A CHANGER !! ! ! !! ! ! !! !! ! ! ! !! ! !
        'type_conciergerie' => $type_conciergerie,
        'idutilisateur' => $demande['utilisateur_id'],
        'pays' => $demande['pays'],
        'type_location' => $demande['type_location'],
        'capacite' => $demande['capacite']
    ]);

    if ($result) {
        $query = $db->prepare("UPDATE demandebailleurs SET etat = 'Acceptée' WHERE id = :id");
        $query->execute(['id' => $idDemande]);

        echo "<div class='container mt-5'><p>Demande acceptée avec succès.</p></div>";

    } else {
        echo "<div class='container mt-5'><p>Une erreur s'est produite lors de l'acceptation de la demande.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Aucune demande trouvée avec l'ID fourni.</p></div>";
}

include_once '../../../Site/template/footer.php';
