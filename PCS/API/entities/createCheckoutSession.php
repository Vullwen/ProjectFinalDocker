<?php
$secret_key = 'sk_test_51PJWq3IfbvrWQjMk8MxdQLumkbyVZFhRI96IOQwcp0z58Q5nD7mu7iJtzZ9Ct1e2b9phwFkXOuYpc39vpXVdI6re00vDc09xiV';

// Fonction de connexion à la base de données
function connectDB() {
    $host = 'localhost';
    $db = 'votre_base_de_donnees';
    $user = 'votre_utilisateur';
    $pass = 'votre_mot_de_passe';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        echo json_encode(['error' => 'Database connection error: ' . $e->getMessage()]);
        exit;
    }
}

$conn = connectDB();

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID du logement manquant']);
    exit;
}

$id_logement = $_GET['id'];

$query = "SELECT prix FROM logements WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->execute(['id' => $id_logement]);
$logement = $stmt->fetch();

if ($logement) {
    $prix = $logement['prix'];
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Logement non trouvé']);
    exit;
}

$session_data = [
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Paiement pour le logement',
            ],
            'unit_amount' => $prix * 100, // Le prix doit être en centimes
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'https://votre-site.com/success.html',
    'cancel_url' => 'https://votre-site.com/cancel.html',
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/checkout/sessions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($session_data));
curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ':');

$headers = [];
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL error: ' . curl_error($ch)]);
    exit;
}

$response = json_decode($result, true);

curl_close($ch);

if (isset($response['id'])) {
    echo json_encode(['id' => $response['id']]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de la création de la session']);
}
?>
