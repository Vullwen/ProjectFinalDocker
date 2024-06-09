<?php
require_once '../../API/database/connectDB.php';
require_once '../template/header.php';
require_once 'librairies/autoload.php';

$secret_key = 'sk_test_51PJWq3IfbvrWQjMk8MxdQLumkbyVZFhRI96IOQwcp0z58Q5nD7mu7iJtzZ9Ct1e2b9phwFkXOuYpc39vpXVdI6re00vDc09xiV';
\Stripe\Stripe::setApiKey($secret_key);

$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservationId = filter_input(INPUT_POST, 'reservationId', FILTER_SANITIZE_NUMBER_INT);
    $prixTotal = filter_input(INPUT_POST, 'prixTotal', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $stripeToken = filter_input(INPUT_POST, 'stripeToken', FILTER_SANITIZE_STRING);

    if (!$reservationId || !$prixTotal || !$name || !$email || !$stripeToken) {
        echo json_encode(['error' => 'Données invalides']);
        exit;
    }

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $prixTotal * 100,
            'currency' => 'eur',
            'description' => 'Paiement pour le logement',
            'source' => $stripeToken,
            'receipt_email' => $email,
            'metadata' => [
                'name' => $name,
                'reservationId' => $reservationId,
            ],
        ]);

        $query = $conn->prepare("UPDATE reservation SET isPaid = 1 WHERE IDReservation = :reservationId");
        $query->execute(['reservationId' => $reservationId]);

        echo json_encode(['success' => 'Paiement effectué avec succès']);
    } catch (\Stripe\Exception\CardException $e) {
        echo json_encode(['error' => 'Erreur de paiement : ' . $e->getMessage()]);
    }
}
?>
