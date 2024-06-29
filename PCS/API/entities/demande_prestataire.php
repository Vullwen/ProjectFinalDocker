<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../database/connectDB.php";

$pdo = connectDB();


$data = json_decode(file_get_contents("php://input"), true);


$nom = htmlspecialchars(strip_tags($data['nom']));
$prenom = htmlspecialchars(strip_tags($data['prenom']));
$siret = htmlspecialchars(strip_tags($data['siret']));
$adresse = htmlspecialchars(strip_tags($data['adresse']));
$email = htmlspecialchars(strip_tags($data['email']));
$telephone = htmlspecialchars(strip_tags($data['telephone']));
$domaine = htmlspecialchars(strip_tags($data['domaine']));


$sql = "INSERT INTO demandes_prestataires (nom, prenom, siret, adresse, email, telephone, domaine, status) VALUES (:nom, :prenom, :siret, :adresse, :email, :telephone, :domaine, :status)";
$stmt = $pdo->prepare($sql);


try {
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':siret' => $siret,
        ':adresse' => $adresse,
        ':email' => $email,
        ':telephone' => $telephone,
        ':domaine' => $domaine,
        ':status' => 'En attente'
    ]);
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Demande de prestataire ajoutée avec succès.']);
} catch (PDOException $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Une erreur s\'est produite lors de l\'ajout de la demande de prestataire.']);
}
?>