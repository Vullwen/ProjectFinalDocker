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
    $insertQuery = $db->prepare("
        INSERT INTO bienimmobilier 
        (type_conciergerie, autre_conciergerie, adresse, pays, type_bien, type_location, nombre_chambres, capacite, nom, telephone, email, heure_contact, etat)
        VALUES
        (:type_conciergerie, :autre_conciergerie, :adresse, :pays, :type_bien, :type_location, :nombre_chambres, :capacite, :nom, :telephone, :email, :heure_contact, :etat)
    ");

    $result = $insertQuery->execute([
        'type_conciergerie' => $demande['type_conciergerie'],
        'autre_conciergerie' => $demande['autre_conciergerie'],
        'adresse' => $demande['adresse'],
        'pays' => $demande['pays'],
        'type_bien' => $demande['type_bien'],
        'type_location' => $demande['type_location'],
        'nombre_chambres' => $demande['nombre_chambres'],
        'capacite' => $demande['capacite'],
        'nom' => $demande['nom'],
        'telephone' => $demande['telephone'],
        'email' => $demande['email'],
        'heure_contact' => $demande['heure_contact'],
        'etat' => 'Acceptée'
    ]);

    if ($result) {
        $deleteQuery = $db->prepare("DELETE FROM demandebailleurs WHERE id = :id");
        $deleteQuery->execute(['id' => $idDemande]);

        echo "<div class='container mt-5'><p>La demande a été acceptée avec succès et les informations ont été enregistrées.</p></div>";
    } else {
        echo "<div class='container mt-5'><p>Erreur lors de l'acceptation de la demande. Veuillez réessayer plus tard.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Aucune demande trouvée avec l'ID fourni.</p></div>";
}

include_once '../../../Site/template/footer.php';
?>