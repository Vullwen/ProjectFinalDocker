<?php
header('Content-Type: application/json');

require_once '../../../API/database/connectDB.php';

$databaseConnection = connectDB();

$query = "SELECT * FROM bienimmobilier WHERE 1=1";
$params = [];

if (!empty($_GET['location'])) {
    $query .= " AND adresse LIKE ?";
    $params[] = '%' . $_GET['location'] . '%';
}
if (!empty($_GET['arrivalDate'])) {
    $query .= " AND dateArrivee >= ?";
    $params[] = $_GET['arrivalDate'];
}
if (!empty($_GET['departureDate'])) {
    $query .= " AND dateDepart <= ?";
    $params[] = $_GET['departureDate'];
}
if (!empty($_GET['bedrooms'])) {
    $query .= " AND nbChambres >= ?";
    $params[] = $_GET['bedrooms'];
}

$stmt = $databaseConnection->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

function fetchPhoto($idBien)
{
    $photoUrl = "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/demandesBiens/photos?id=" . $idBien;
    $photoResponse = file_get_contents($photoUrl);
    $photoData = json_decode($photoResponse, true);

    if ($photoData && isset($photoData['data'][0])) {
        return $photoData['data'][0]['cheminPhoto'];
    }
    return null;
}

foreach ($results as &$result) {
    $result['photo'] = fetchPhoto($result['IDBien']);
}

echo json_encode($results);
