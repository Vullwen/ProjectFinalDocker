<?php
require_once '../template/header.php';

if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit();
}
?>

<script>
    document.addEventListener('DOMContentLoaded' {
        const token = <?php echo json_encode($_SESSION['token']); ?>;

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/id', {
            method: 'GET',
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            console.log(response.json());
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                alert('Erreur lors de la récupération de l\'ID de l\'utilisateur');
                return;
            }
            const userId = data.[0].idutilisateur;
            console.log('ID utilisateur:', userId);

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
            if (!data.success) {
                alert('Erreur lors de la récupération des informations de l\'utilisateur COUCOU C MOI');
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
        document.getElementById('email').value = user.email;
        document.getElementById('telephone').value = user.telephone;
    }

    function updateUserInfos() {
        const token = <?php echo json_encode($_SESSION['token']); ?>;
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
        const email = document.getElementById('email').value;
        const telephone = document.getElementById('telephone').value;
        const password = document.getElementById('password').value;

        const data = { email, telephone };
        if (password) {
            data.password = password;
        }

        fetch('http://51.75.69.184/2A-ProjetAnnuel/PCS/API/user/update?id=' + userId, {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    alert('Erreur lors de la mise à jour des informations de l\'utilisateur');
                    return;
                }
                alert('Informations mises à jour avec succès');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la mise à jour des informations de l\'utilisateur');
            });
    }
</script>

<div class="container mt-5">
    <h2>Modifier vos informations</h2>
    <form onsubmit="event.preventDefault(); updateUserInfos();">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" id="telephone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>

<?php
require_once '../template/footer.php';
?>