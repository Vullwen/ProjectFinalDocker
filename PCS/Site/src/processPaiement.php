<?php
require_once '../template/header.php';
require_once 'librairies/autoload.php';

$secret_key = 'sk_test_51PJWq3IfbvrWQjMk8MxdQLumkbyVZFhRI96IOQwcp0z58Q5nD7mu7iJtzZ9Ct1e2b9phwFkXOuYpc39vpXVdI6re00vDc09xiV';
\Stripe\Stripe::setApiKey($secret_key);

$api_base_url = "http://localhost/2A-ProjetAnnuel/PCS/API";

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
        $response = callAPI('POST', "$api_base_url/payment", [
            'reservationId' => $reservationId,
            'prixTotal' => $prixTotal,
            'name' => $name,
            'email' => $email,
            'stripeToken' => $stripeToken
        ]);

        $responseData = json_decode($response, true);

        if (isset($responseData['success'])) {
            $update_response = callAPI('PUT', "$api_base_url/reservation/$reservationId", [
                'isPaid' => true
            ]);

            echo json_encode(['success' => 'Paiement effectué avec succès']);
        } else {
            echo json_encode(['error' => 'Erreur de paiement : ' . $responseData['error']]);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Erreur de paiement : ' . $e->getMessage()]);
    }
}