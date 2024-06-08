<?php
require_once '../../API/database/connectDB.php';
include_once '../template/header.php';
require_once 'librairies/autoload.php';

$secret_key = 'sk_test_51PJWq3IfbvrWQjMk8MxdQLumkbyVZFhRI96IOQwcp0z58Q5nD7mu7iJtzZ9Ct1e2b9phwFkXOuYpc39vpXVdI6re00vDc09xiV';
\Stripe\Stripe::setApiKey($secret_key);

// Se connecter à la base de données
$conn = connectDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $logement_id = filter_input(INPUT_POST, 'logement_id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $stripeToken = filter_input(INPUT_POST, 'stripeToken', FILTER_SANITIZE_STRING);

    if (!$logement_id || !$name || !$email || !$stripeToken) {
        echo json_encode(['error' => 'Données invalides']);
        exit;
    }

    // Récupérer le prix du logement
    $query = "SELECT tarif FROM bienimmobilier WHERE IDBIEN = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute(['id' => $logement_id]);
    $logement = $stmt->fetch();

    if ($logement) {
        $prix = $logement['prix'];
    } else {
        echo json_encode(['error' => 'Logement non trouvé']);
        exit;
    }

    try {
        // Créer une charge Stripe
        $charge = \Stripe\Charge::create([
            'amount' => $prix * 100, // Le prix doit être en centimes
            'currency' => 'eur',
            'description' => 'Paiement pour le logement',
            'source' => $stripeToken,
            'receipt_email' => $email,
            'metadata' => [
                'name' => $name,
                'logement_id' => $logement_id,
            ],
        ]);

        echo json_encode(['success' => 'Paiement effectué avec succès']);
    } catch (\Stripe\Exception\CardException $e) {
        echo json_encode(['error' => 'Erreur de paiement : ' . $e->getMessage()]);
    }
}
?>
