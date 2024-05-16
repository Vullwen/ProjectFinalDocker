const express = require('express');
const cors = require('cors');
const { NlpManager } = require('node-nlp');

const app = express();
app.use(cors());

const port = 3000;

const manager = new NlpManager({ languages: ['fr'] });
manager.addDocument('fr', 'bonjour', 'greetings.hello');
manager.addDocument('fr', 'salut', 'greetings.hello');
manager.addDocument('fr', 'au revoir', 'greetings.bye');
manager.addAnswer('fr', 'greetings.hello', 'Salut! Comment puis-je vous aider?');
manager.addAnswer('fr', 'greetings.bye', 'Au revoir! Bonne journée!');
manager.train().then(() => console.log('Entraînement terminé'));

app.use(express.json());

app.post('/message', async (req, res) => {
    const { message } = req.body;
    const response = await manager.process('fr', message);
    res.send({ answer: response.answer });
});

app.listen(port, () => {
    console.log(`Serveur en écoute sur http://localhost:${port}`);
});
