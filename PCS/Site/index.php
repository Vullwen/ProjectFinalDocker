<?php
include_once 'template/header.php';
?>

<div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img\photo1.png" class="d-block w-100" alt="Image 1">
      <div class="carousel-caption d-none d-md-block">
        <h5>Votre Bien, Notre Priorité</h5>
        <p>Explorez le meilleur de la gestion locative avec PCS.</p>
        <a href="#" class="btn btn-primary" data-aos="fade-up">En savoir plus</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img\photo2.png" class="d-block w-100" alt="Image 2">
      <div class="carousel-caption d-none d-md-block">
        <h5>Service Exceptionnel</h5>
        <p>Un service à la hauteur de vos attentes.</p>
        <a href="#" class="btn btn-primary" data-aos="fade-up">Découvrir</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img\call.png" class="d-block w-100" alt="Image 3">
      <div class="carousel-caption d-none d-md-block">
        <h5>À Votre Écoute</h5>
        <p>Nous sommes là pour vous, 24/7.</p>
        <a href="#" class="btn btn-primary" data-aos="fade-up">Contactez-nous</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Précédent</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Suivant</span>
  </button>
</div>

<section class="container text-center my-5">
  <h2 class="mb-4" style="color: #003366;">Nos services</h2>
  <div class="row g-4">
    <div class="col-md-4" data-aos="fade-up">
      <img src="img\menage.png" alt="Icone service" width="200px" class="mb-3">
      <h5 style="color: #DAA520;">Service de nettoyage</h5>
      <p style="color: #4D4D4D;">Nous offrons un service de nettoyage professionnel pour maintenir votre bien en
        parfait état.</p>
    </div>
  </div>
</section>

<footer class="text-center py-4" style="background-color: #003366; color: #DAA520;">
  <p>© 2024 Paris Caretaker Services. Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>

</html>