<?php
include_once '../../../Site/template/header.php';
if (isAdmin()) {
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <body>
        <div class="container mt-5">
            <h1>Tableau de bord Admin</h1>


            <h2>Demandes de Prestataires</h2>
            <div id="demandesPrestataires"></div>
            <a href="../../index.php" class="btn btn-primary">Retour au Dashboard Admin</a>

            <?php
} else {
    echo "<div class='container mt-5'>";
    echo "<p>Vous n'êtes pas autorisé à accéder à cette page.</p>";
    echo "</div>";

}
?>

        <script>
            $(document).ready(function () {
                fetchDemandesPrestataires();

                function fetchDemandesPrestataires() {
                    $.ajax({
                        url: 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/prestataires/demandes',
                        method: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                let demandesHtml = '<table class="table"><thead><tr><th>Nom</th><th>Prénom</th><th>SIRET</th><th>Adresse</th><th>Email</th><th>Téléphone</th><th>Domaine</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
                                response.data.forEach(function (demande) {
                                    demandesHtml += `<tr>
                                    <td>${demande.nom}</td>
                                    <td>${demande.prenom}</td>
                                    <td>${demande.siret}</td>
                                    <td>${demande.adresse}</td>
                                    <td>${demande.email}</td>
                                    <td>${demande.telephone}</td>
                                    <td>${demande.domaine}</td>
                                    <td>${demande.status}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm" onclick="accepterDemande(${demande.id})">Accepter</button>
                                        <button class="btn btn-danger btn-sm" onclick="refuserDemande(${demande.id})">Refuser</button>
                                    </td>
                                </tr>`;
                                });
                                demandesHtml += '</tbody></table>';
                                $('#demandesPrestataires').html(demandesHtml);
                            } else {
                                $('#demandesPrestataires').html('<p>Aucune demande trouvée.</p>');
                            }
                        },
                        error: function (error) {
                            console.error('Erreur:', error);
                            $('#demandesPrestataires').html('<p>Erreur lors de la récupération des demandes.</p>');
                        }
                    });
                }
            });

            function accepterDemande(id) {
                $.ajax({
                    url: 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/entities/accepter_demande_prestataire.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: id }),
                    success: function (response) {
                        if (response.success) {
                            alert('Demande acceptée avec succès.');
                            location.reload();
                        } else {
                            alert('Erreur lors de l\'acceptation de la demande : ' + response.message + ' Erreur : ' + (response.error || ''));
                        }
                    },
                    error: function (error) {
                        console.error('Erreur:', error);
                        alert('Erreur lors de l\'acceptation de la demande.');
                    }
                });
            }



            function refuserDemande(id) {
                alert('Demande refusée: ' + id);
            }
        </script>

    </div>