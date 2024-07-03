<?php
include_once '../template/header.php';
?>
<div id="app" class="container mt-5">
    <h1>Rechercher des Biens Immobiliers</h1>
    <form @submit.prevent="fetchProperties">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="location">Lieu</label>
                <input type="text" class="form-control" id="location" v-model="searchParams.location"
                    placeholder="Entrez un lieu">
            </div>
            <div class="form-group col-md-3">
                <label for="arrivalDate">Date d'arrivée</label>
                <input type="date" class="form-control" id="arrivalDate" v-model="searchParams.arrivalDate">
            </div>
            <div class="form-group col-md-3">
                <label for="departureDate">Date de départ</label>
                <input type="date" class="form-control" id="departureDate" v-model="searchParams.departureDate">
            </div>
        </div>
        <div class="form-group">
            <label for="adults">Adultes (13 ans et plus)</label>
            <input type="number" class="form-control" id="adults" v-model="searchParams.adults">
        </div>
        <div class="form-group">
            <label for="children">Enfants (moins de 13 ans)</label>
            <input type="number" class="form-control" id="children" v-model="searchParams.children">
        </div>
        <div class="form-group">
            <label for="bedrooms">Chambres</label>
            <select id="bedrooms" class="form-control" v-model="searchParams.bedrooms">
                <option value="">Sélectionner le nombre de chambres</option>
                <option value="1">1 chambre</option>
                <option value="2">2 chambres</option>
                <option value="3">3 chambres</option>
                <option value="4">4 chambres</option>
                <option value="5">5 chambres</option>
                <option value="6">6 chambres ou plus</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>
    <div v-if="properties.length > 0">
        <h2>Résultats de la recherche :</h2>
        <div class="card" v-for="property in properties" :key="property.IDBien">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" v-for="(photo, index) in property.photos.slice(1)"
                        :data-bs-target="'#carouselExampleIndicators'" :data-bs-slide-to="index + 1"
                        :aria-label="'Slide ' + (index + 2)"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(photo, index) in property.photos"
                        :class="{ active: index === 0 }">
                        <img :src="photo" class="d-block w-100" alt="Photo du bien immobilier">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="card-body">
                <h5 class="card-title">{{ property.Type }} - {{ property.Adresse }}</h5>
                <p class="card-text">Description: {{ property.Description }}</p>
                <p class="card-text">Superficie: {{ property.Superficie }} m²</p>
                <p class="card-text">Nombre de Chambres: {{ property.NbChambres }}</p>
                <p class="card-text">Tarif: {{ property.Tarif }}€/nuit</p>
                <p class="card-text">Disponibilité: {{ property.Disponibilite }}</p>
                <a :href="'reservation.php?id=' + property.IDBien" class="btn btn-primary">Voir plus</a>
            </div>
        </div>
    </div>
    <div v-else>
        <p>Aucun bien trouvé.</p>
    </div>
</div>

<script src="../javascript/searchProperties.js"></script>