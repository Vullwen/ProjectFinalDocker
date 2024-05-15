<?php

include_once '../template/header.php';
?>
<h1> Devenir Bailleur chez ParisCareTaker ! </h1>

<form id="devenirBailleurForm">
    <div class="form-group">
        <label for="conciergerie">Quel type de conciergerie souhaitez-vous ?<span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="radio" id="aaz" name="conciergerie" value="De A à Z">
        <label for="aaz">De A à Z</label><br>
        <input type="radio" id="void" name="conciergerie" value="Void management">
        <label for="void">Void management</label><br>
        <input type="radio" id="autre" name="conciergerie" value="Autre">
        <label for="autre">Autre</label><br>
        <input type="text" id="autreConciergerie" name="autreConciergerie" placeholder="Autre (précisez)">
    </div>

    <div class="form-group">
        <label for="adresse">Adresse de votre propriété en location courte durée <span class="obligatoire">
                (obligatoire)</span>:</label><br>
        <input type="text" id="adresse" name="adresse">
    </div>

    <div class="form-group">
        <label for="pays">Pays de votre propriété en location courte durée <span class="obligatoire">
                (obligatoire)</span></label><br>
        <select id="pays" name="pays">
            <option value="France">France</option>
            <option value="Espagne">Espagne</option>
            <option value="Italie">Italie</option>
            <option value="Allemagne">Allemagne</option>
            <option value="Royaume-Uni">Royaume-Uni</option>
            <option value="Belgique">Belgique</option>
            <option value="Suisse">Suisse</option>

        </select>
    </div>

    <div class="form-group">
        <label for="typeBien">Type de bien <span class="obligatoire">
                (obligatoire)</span></label><br>
        <select id="typeBien" name="typeBien">
            <option value="Appartement">Appartement</option>
            <option value="Maison">Maison</option>
        </select>
    </div>

    <div class="form-group">
        <label for="typeLocation">Type de location<span class="obligatoire">
                (obligatoire)</span> </label><br>
        <select id="typeLocation" name="typeLocation">
            <option value="Logement complet">Logement complet</option>
            <option value="Chambres">Chambres</option>
            <option value="Colocation">Colocation</option>
        </select>
    </div>

    <div class="form-group">
        <label for="nombreChambres">Nombre de chambres <span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="number" id="nombreChambres" name="nombreChambres">
    </div>

    <div class="form-group">
        <label for="capacite">Quelle est la capacité d'accueil de votre logement ?<span class="obligatoire">
                (obligatoire)</span></label><br>
        <select id="capacite" name="capacite">
            <option value="1">1 personne</option>
            <option value="2">2 personnes</option>
            <option value="3">3 personnes</option>
            <option value="4">4 personnes</option>
            <option value="5">5 personnes</option>
            <option value="6">6 personnes</option>
            <option value="7">7 personnes</option>
            <option value="8">8 personnes</option>
            <option value="9">9 personnes</option>
            <option value="10">10 personnes</option>
            <option value="11">11 personnes</option>
            <option value="12+">12 personnes et plus</option>
        </select>
    </div>

    <div class="form-group">
        <label for="nom">Nom et Prénom <span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="text" id="nom" name="nom">
    </div>

    <div class="form-group">
        <label for="email">Email <span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="email" id="email" name="email">
    </div>

    <div class="form-group">
        <label for="telephone">Téléphone<span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="tel" id="telephone" name="telephone">
    </div>

    <div class="form-group">
        <label>A quelle heure souhaitez-vous être contacté ?<span class="obligatoire">
                (obligatoire)</span></label><br>
        <input type="radio" id="avant12h" name="contact" value="Avant 12h00">
        <label for="avant12h">Avant 12h00</label><br>
        <input type="radio" id="entre12h14h" name="contact" value="Entre 12h00 et 14h00">
        <label for="entre12h14h">Entre 12h00 et 14h00</label><br>
        <input type="radio" id="entre14h18h" name="contact" value="Entre 14h00 et 18h00">
        <label for="entre14h18h">Entre 14h00 et 18h00</label><br>
        <input type="radio" id="apres18h" name="contact" value="Après 18h00">
        <label for="apres18h">Après 18h00</label>
    </div>

    <div class="form-group">
        <input type="checkbox" id="acceptation" name="acceptation">
        <label for="acceptation">Pour soumettre ce formulaire, vous devez accepter notre Déclaration de
            confidentialité.<span class="obligatoire">
                (obligatoire)</span></label><br>
        <a href="#">Déclaration de confidentialité</a>
    </div>

    <button type="submit">RECEVOIR MON ETUDE DE RENTABILITE</button>
</form>