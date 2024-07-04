<?php
include_once '../template/header.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit();
}
?>

<div class="container mt-5">
    <h2>Votre Profil</h2>
    <div id="profile-info">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = <?php echo json_encode($_SESSION['token']); ?>;

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id', {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + token }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    alert('Erreur lors de la récupération de l\'ID de l\'utilisateur');
                    return;
                }
                const userId = data.user_id;

                return fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user?id=' + userId, {
                    method: 'GET',
                    headers: { 'Authorization': 'Bearer ' + token }
                });
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data) {
                    alert('Erreur lors de la récupération des informations de l\'utilisateur');
                    return;
                }
                displayUserInfos(data[0]);
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la récupération des informations de l\'utilisateur');
            });
    });

    function displayUserInfos(user) {
        const profileInfoDiv = document.getElementById('profile-info');
        profileInfoDiv.innerHTML = `
            <p><strong>Nom :</strong> ${user.nom}</p>
            <p><strong>Prénom :</strong> ${user.prenom}</p>
            <p><strong>Email :</strong> ${user.email}</p>
            <p><strong>Téléphone :</strong> ${user.telephone}</p>
            <p><strong>Date d'inscription :</strong> ${user.DateInscription}</p>
        `;
    }
</script>

<?php
include_once '../template/footer.php';
?>