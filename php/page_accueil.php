<?php session_start(); ?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/page_accueil.css" />
    <script src="../js/base.js" defer></script>
    <script src="../js/page_accueil.js" defer></script>
    <title>Time to Travel</title>
  </head>

  <body>
    <header>
      <video autoplay loop muted playsinline id="background-video">
        <source src="../img/video_fond.mp4" type="video/mp4" />
        Votre navigateur ne supporte pas la vidéo.
      </video>
      <?php require_once './partials/nav.php' ?>
     <form method="GET" action="./recherche.php" class="form-recherche">
  <input type="search" name="q" placeholder="Rechercher un voyage..." />
  <button type="submit">🔍</button>
</form>

    </header>
    <main>
      <!--<section id="choice">
        <aside>
          <div>
            <span>
              Voyagez dans le passé, et découvrez le commencement de tout ce que
              vous connaissez.
            </span>
            <a href="./page_past.php">Plus d'infos</a>
          </div>
        </aside>
        <aside>
          <div>
            <span>
              Voyagez dans le futur, et découvrez le le résultat de tout vos
              efforts.
            </span>
            <a href="./page_futur.php">Plus d'infos</a>
          </div>
        </aside>
      </section>-->
     <section class="section-voyages scroll-intro">
  <h2 class="titre-voyages">Envie de partir à l’aventure ?</h2>
  <div class="grid-voyages">
    <?php require_once './get_random_voyages.php'; ?>
  </div>
</section>



      <section id="past">
        <img src="../img/accueil_past.avif" alt="Paysage du passé" />
        <aside>
          <h2>Passé</h2>
          <p>Un texte</p>
          <p>Un autre texte</p>
          <p>J'ai pas d'idée</p>
          <p>C'est pas grave on verra plus tard</p>
        </aside>
      </section>
      <section id="future">
        <aside>
          <h2>Futur</h2>
          <p>Un texte</p>
          <p>Un autre texte</p>
          <p>J'ai pas d'idée</p>
          <p>C'est pas grave on verra plus tard</p>
        </aside>
        <img src="../img/accueil_future.jpg" alt="Paysage du futur" />
      </section>
    </main>
  </body>
</html>
