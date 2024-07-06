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