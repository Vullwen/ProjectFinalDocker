<?php
include __DIR__ . "/../../database/connectDB.php";

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $reservationId = $_GET['id'];
        $db = connectDB();

        $query = $db->prepare("
            SELECT r.*, u.nom, u.email, u.telephone 
            FROM reservation r
            JOIN utilisateur u ON r.IDUtilisateur = u.IDUtilisateur
            WHERE r.IDReservation = :IDReservation
        ");
        $query->execute(['IDReservation' => $reservationId]);
        $reservation = $query->fetch(PDO::FETCH_ASSOC);

        if ($reservation) {
            echo json_encode([
                'success' => true,
                'reservation' => $reservation
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Réservation non trouvée.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Requête invalide.'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur serveur: ' . $e->getMessage()
    ]);
}
?>