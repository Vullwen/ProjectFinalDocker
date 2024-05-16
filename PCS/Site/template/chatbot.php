<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Chat avec notre Bot</h1>
    <input type="text" id="userInput" placeholder="Dites quelque chose..." />
    <button onclick="sendMessage()">Envoyer</button>
    <p id="botResponse"></p>

    <script>
        function sendMessage() {
            const userInput = document.getElementById('userInput');
            const userMessage = userInput.value.trim(); 

            if (!userMessage) {
                document.getElementById('botResponse').innerText = "Veuillez écrire quelque chose avant d'envoyer.";
                return;
            }

            axios.post('http://localhost:3000/message', { message: userMessage })
                .then(response => {
                    document.getElementById('botResponse').innerText = "Réponse du bot: " + response.data.answer;
                    userInput.value = ''; 
                })
                .catch(error => {
                    console.error('Erreur lors de l\'envoi du message:', error);
                    document.getElementById('botResponse').innerText = "Erreur lors de l'envoi du message. Veuillez réessayer.";
                });
        }
    </script>
</body>
</html>
