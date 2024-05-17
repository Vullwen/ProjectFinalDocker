<?php
include_once '../../../Site/template/header.php';
include_once '../../../API/database/connectDB.php';

// Connexion à la base de données
$databaseConnection = connectDB();
if (!$databaseConnection) {
    die("La connexion à la base de données a échoué.");
}

// Requête pour récupérer les demandes des bailleurs
$getDemandesQuery = $databaseConnection->query("SELECT id, nom, telephone, email, adresse FROM demandebailleurs");

// Vérification si des demandes ont été trouvées
if ($getDemandesQuery->rowCount() > 0) {
    ?>
    <div class="container mt-5">
        <h2>Demandes des bailleurs</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Numéro de demande</th>
                    <th scope="col">Nom du propriétaire</th>
                    <th scope="col">Télephone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Détails</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($demande = $getDemandesQuery->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($demande['id']); ?></th>
                        <td><?php echo htmlspecialchars($demande['nom']); ?></td>
                        <td><?php echo htmlspecialchars($demande['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($demande['email']); ?></td>
                        <td><?php echo htmlspecialchars($demande['adresse']); ?></td>
                        <td><a href="details_demande.php?id=<?php echo htmlspecialchars($demande['id']); ?>">Voir détails</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    // Aucune demande trouvée
    echo "<div class='container mt-5'><p>Aucune demande de bailleur n'a été trouvée.</p></div>";
}

// Fermeture de la connexion à la base de données
$databaseConnection = null;
?>