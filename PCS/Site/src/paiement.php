<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement du Logement</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h2>Paiement pour le Logement</h2>
    <form id="payment-form" action="processPaiement.php" method="post">
        <input type="hidden" name="logement_id" value="123">
        
        <div>
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="card-element">Carte de Crédit</label>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>
        <button type="submit">Payer</button>
    </form>

    <script>
        var stripe = Stripe('pk_test_51PJWq3IfbvrWQjMkx3fn3dS5YeqCLPUv42gDFSImMvEsCcVwNt35vwJVJUR5ei7VXocgBlkz7inhZMax3pnTnETR00FNkwN1iF');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    </script>
</body>
</html>
