<?php
require_once '../../../Site/template/header.php';
require_once '../../../API/database/connectDB.php';

try {
    $conn = connectDB();

    $query = "SELECT * FROM reservation WHERE Status = 'Pending'";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    die('Erreur : ' . $exception->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Réservations en Attente</h1>
        <div id="message"></div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IDUtilisateur</th>
                    <th>IDBien</th>
                    <th>DateDebut</th>
                    <th>DateFin</th>
                    <th>Tarif</th>
                    <th>Invité</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['IDReservation']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['IDUtilisateur']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['IDBien']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['DateDebut']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['DateFin']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['Tarif']); ?></td>
                    <td>
                        <button class="btn btn-success" onclick="updateReservationStatus('<?php echo htmlspecialchars($reservation['ID']); ?>', 'accept')">Accepter</button>
                        <button class="btn btn-danger" onclick="updateReservationStatus('<?php echo htmlspecialchars($reservation['ID']); ?>', 'reject')">Refuser</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function updateReservationStatus(id, action) {
            const endpoint = action === 'accept' ? 'acceptReservation.php' : 'rejectReservation.php';
            const messageDiv = document.getElementById('message');

            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message.includes('succès')) {
                    messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Erreur:', error);
                messageDiv.innerHTML = `<div class="alert alert-danger">Une erreur est survenue.</div>`;
            });
        }
    </script>
</body>
</html>