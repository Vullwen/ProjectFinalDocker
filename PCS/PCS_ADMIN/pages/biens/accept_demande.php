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
            IDUtilisateur: <?php echo $demande['utilisateur_id']; ?>,
            Tarif: <?php echo $demande['tarif']; ?>,
            Adresse: "<?php echo $demande['adresse']; ?>",
            Pays: "<?php echo $demande['pays']; ?>",
            Type_bien: "<?php echo $demande['type_bien']; ?>",
            type_location: "<?php echo $demande['type_location']; ?>",
            Superficie: <?php echo $demande['superficie']; ?>,
            NbChambres: <?php echo $demande['nombre_chambres']; ?>,
            Capacite: <?php echo $demande['capacite']; ?>,
            Description: "<?php echo $demande['description']; ?>",
            Type_conciergerie: "<?php echo $demande['type_conciergerie']; ?>"

        }));

    }
</script>