### Documentation

#### Construire, démarrer et interagir avec l'application

1. **Cloner le dépôt**
    ```sh
    git clone https://github.com/Vullwen/ProjectFinalDocker
    cd ProjectFinalDocker
    ```

2. **Construire et démarrer les conteneurs**
    ```sh
    docker-compose up --build
    ```

3. **Accéder à l'application**
    - Backend: `http://localhost:8080/api`
    - Frontend: `http://localhost:8081/site` ou `http://localhost:8081/pcs_prestataire`
    - Base de données MySQL accessible sur le port 3306 (optionnel, pour outils de gestion de DB)

#### Explications sur l'architecture

L'application est divisée en trois services principaux dans Docker :
- **Backend** : Héberge l'API.
- **Frontend** : Contient les interfaces utilisateur du site et des prestataires.
- **Database** : Un serveur MySQL pour stocker les données de l'application.

#### Description des choix de volumes et réseaux

- **Volumes** :
    - `./Backend:/var/www/html` : Permet de synchroniser les fichiers de l'application backend entre l'hôte et le conteneur pour faciliter le développement.
    - `./Frontend:/var/www/html` : Permet de synchroniser les fichiers de l'application frontend entre l'hôte et le conteneur.
    - `db-data:/var/lib/mysql` : Volume nommé pour persister les données MySQL entre les redémarrages des conteneurs.

- **Réseaux** :
    - `app-network` : Réseau bridge personnalisé permettant aux conteneurs de communiquer entre eux.

- **Images Docker** :
    - `https://hub.docker.com/repository/docker/vullwen/frontend/general` : Image Docker pour le frontend.
    - `https://hub.docker.com/repository/docker/vullwen/backend/general` : Image Docker pour le backend.

### Commandes supplémentaires utiles

- **Démarrer les conteneurs en arrière-plan** :
    ```sh
    docker-compose up -d
    ```

- **Voir les logs des conteneurs** :
    ```sh
    docker-compose logs -f
    ```

- **Arrêter et supprimer les conteneurs, les réseaux et les volumes créés par `docker-compose up`** :
    ```sh
    docker-compose down
    ```

### Explication des choix

1. **Instructions pour construire, démarrer et interagir avec l'application** :
   - **Construction** : Nous avons inclus des `Dockerfile` distincts pour le backend et le frontend. Chaque service a toutes les dépendances nécessaires configurées et copie les fichiers dans les bons répertoires.
   - **Démarrage** : Le fichier `docker-compose.yml` vous permet de démarrer tous les services en une seule commande, rendant le processus beaucoup plus simple.
   - **Interaction** : Nous avons exposé les ports de manière à ce que vous puissiez accéder facilement à chaque partie de l'application. Le backend est accessible via le port 8080 et le frontend via le port 8081. La base de données est déjà configurée avec un mot de passe et une base de données spécifique.

2. **Architecture Docker** :
   - **Backend et Frontend** : Nous avons séparé le backend et le frontend dans leurs propres conteneurs pour faciliter la maintenance et le déploiement, et permet de gérer chaque partie de l'application de manière indépendante.
   - **Base de données** : Nous avons inclus un service de base de données MySQL avec les volumes nécessaires pour assurer la persistance des données.

3. **Choix de volumes et réseaux** :
   - **Volumes** :
     - Les volumes pour le backend et le frontend (`./Backend` et `./Frontend`) montent les répertoires de code directement dans les conteneurs. Cela permet de voir les changements en temps réel sans avoir à reconstruire les images Docker à chaque fois.
     - Le volume `db-data` pour MySQL garde les données persistantes, même si le conteneur de la base de données est recréé.
     - Le répertoire `./Database` est monté dans le conteneur de la base de données pour initialiser celle-ci avec les scripts nécessaires dès le démarrage.
   - **Réseaux** :
     - Nous avons défini un réseau `app-network` de type bridge pour permettre aux différents services (backend, frontend, base de données) de communiquer entre eux. Cela les isole du réseau par défaut de Docker, ce qui améliore la sécurité et la gestion des connexions réseau.
