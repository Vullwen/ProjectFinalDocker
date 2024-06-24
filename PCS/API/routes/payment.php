<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "database/connectDB.php";
$pdo = connectDB();


$data = json_decode(file_get_contents("php://input"), true);


$reservationId = $data['reservationId'];
$prixTotal = $data['prixTotal'];
$name = $data['name'];
$email = $data['email'];
$stripeToken = $data['stripeToken'];


if (empty($reservationId) || empty($prixTotal) || empty($name) || empty($email) || empty($stripeToken)) {
    http_response_code(400);
    echo json_encode(['error' => 'Tous les champs sont obligatoires']);
    exit;
}


try {

    $query = $pdo->prepare("INSERT INTO reservation (IDReservation, Tarif, IDUtilisateur, ) VALUES (:reservationId, :montant, :nomClient, :emailClient, :tokenStripe)");
    $query->execute([
        'IDReservation' => $reservationId,
        'tarif' => $prixTotal,
        'IDUtilisateur' => $IDUtilisateur,
    ]);


    if ($query->rowCount() > 0) {

        $updateQuery = $pdo->prepare("UPDATE reservations SET est_paye = 1 WHERE id_reservation = :reservationId");
        $updateQuery->execute(['reservationId' => $reservationId]);

        http_response_code(200);
        echo json_encode(['success' => 'Paiement effectué avec succès']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur lors de l\'insertion du paiement']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données : ' . $e->getMessage()]);
}

