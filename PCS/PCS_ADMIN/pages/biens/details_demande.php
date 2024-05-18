<?php
include_once '../../../Site/template/header.php';
include_once '../../../API/database/connectDB.php';

$databaseConnection = connectDB();

if (!$databaseConnection) {
    die("La connexion à la base de données a échoué.");
}


$getDemandesQuery = $databaseConnection->query("SELECT id, type_conciergerie, autre_conciergerie, adresse, pays, type_bien, type_location, nombre_chambres, capacite, nom, telephone, email, heure_contact, etat FROM demandebailleurs");


if ($getDemandesQuery->rowCount() > 0) {
    ?>
    <div class="container mt-5">
        <h2>Demandes des bailleurs</h2>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Numéro de demande</th>
                    <th scope="col">Type de conciergerie</th>
                    <th scope="col">Autre conciergerie</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Pays</th>
                    <th scope="col">Type de bien</th>
                    <th scope="col">Type de location</th>
                    <th scope="col">Nombre de chambres</th>
                    <th scope="col">Capacité</th>
                    <th scope="col">Nom du propriétaire</th>
                    <th scope="col">Télephone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Heure de contact</th>
                    <th scope="col">Etat</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($demande = $getDemandesQuery->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($demande['id']); ?></th>
                        <td><?php echo htmlspecialchars($demande['type_conciergerie']); ?></td>
                        <td><?php echo htmlspecialchars($demande['autre_conciergerie']); ?></td>
                        <td><?php echo htmlspecialchars($demande['adresse']); ?></td>
                        <td><?php echo htmlspecialchars($demande['pays']); ?></td>
                        <td><?php echo htmlspecialchars($demande['type_bien']); ?></td>
                        <td><?php echo htmlspecialchars($demande['type_location']); ?></td>
                        <td><?php echo htmlspecialchars($demande['nombre_chambres']); ?></td>
                        <td><?php echo htmlspecialchars($demande['capacite']); ?></td>
                        <td><?php echo htmlspecialchars($demande['nom']); ?></td>
                        <td><?php echo htmlspecialchars($demande['telephone']); ?></td>
                        <td>
                            <?
                            echo htmlspecialchars($demande['email']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($demande['heure_contact']); ?></td>
                        <td><?php echo htmlspecialchars($demande['etat']); ?></td>
                        <td><a href="details_demande.php?id=<?php echo htmlspecialchars($demande['id']); ?>">Accepter la
                                demande</a>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    echo "<div class='container mt-5'><p>Aucune demande de bailleur n'a été trouvée.</p></div>";
}
