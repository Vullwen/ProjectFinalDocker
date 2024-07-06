<?php
include "../../../Site/template/header.php";

$apiUrlDemandes = 'http://51.75.69.184/2A-ProjetAnnuel/PCS/API/routes/demandebiens?id=' . $_GET['id'];

$response = file_get_contents($apiUrlDemandes);


if ($response === FALSE) {
    die("L'appel à l'API a échoué.");
}

$responseData = json_decode($response, true);

if (!$responseData || !$responseData['success']) {
    die("Aucune demande de bailleur n'a été trouvée ou une erreur s'est produite.");
}

$demande = $responseData['data'];
$demande['tarif'] = $_GET['tarif'];

echo "<script>
    window.onload = function() {
        acceptDemande();
    };
</script>";

?>

<script>

    function acceptDemande() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "http://51.75.69.184/2A-ProjetAnnuel/PCS/API/biens", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("La demande a été acceptée.");
                    window.location.href = "demandeBailleurs.php";
                } else {
                    alert("Une erreur s'est produite.");
                }
            }
        };
        xhr.send(JSON.stringify({
            idutilisateur: <?php echo $demande['utilisateur_id']; ?>,
            tarif: <?php echo $demande['tarif']; ?>,
            adresse: "<?php echo $demande['adresse']; ?>",
            pays: "<?php echo $demande['pays']; ?>",
            type_bien: "<?php echo $demande['type_bien']; ?>",
            type_location: "<?php echo $demande['type_location']; ?>",
            superficie: <?php echo $demande['superficie']; ?>,
            nbchambres: <?php echo $demande['nombre_chambres']; ?>,
            capacite: <?php echo $demande['capacite']; ?>,
            description: "<?php echo $demande['description']; ?>",
            type_conciergerie: "<?php echo $demande['type_conciergerie']; ?>",
            idDemande: <?php echo $demande['id']; ?>

        }));

    }
</script>