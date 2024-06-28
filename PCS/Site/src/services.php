<?php
require_once "../template/header.php"; // Inclusion de l'en-tête commun
?>

<div class="container mt-5">
    <h1>Découvrez nos Prestataires</h1>

    <div id="prestataires-list" class="mt-4">
        <?php
        $apiUrl = 'http://localhost/2A-ProjetAnnuel/PCS/API/prestataires';

        $response = file_get_contents($apiUrl);

        if ($response === false) {
            echo '<p>Erreur lors de la récupération des données des prestataires.</p>';
        } else {
            $prestataires = json_decode($response, true);

            if (isset($prestataires['success']) && $prestataires['success'] === true) {
                foreach ($prestataires['data'] as $prestataire) {
                    echo '<div class="card mb-3">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($prestataire['Nom']) . '</h5>';
                    echo '<p class="card-text"><strong>Domaine :</strong> ' . htmlspecialchars($prestataire['Domaine']) . '</p>';
                    echo '<p class="card-text"><strong>Adresse :</strong> ' . htmlspecialchars($prestataire['Adresse']) . '</p>';
                    echo '<p class="card-text"><strong>Email :</strong> ' . htmlspecialchars($prestataire['Email']) . '</p>';
                    echo '<p class="card-text"><strong>Téléphone :</strong> ' . htmlspecialchars($prestataire['Telephone']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Aucun prestataire trouvé.</p>';
            }
        }
        ?>
    </div>
</div>

<?php
require_once "../template/footer.php";