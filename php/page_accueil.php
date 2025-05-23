<?php
// Démarre la session utilisateur
session_start();
?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <!-- Feuilles de style principales -->
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/page_accueil.css" />
    <!-- Fichiers JavaScript -->
    <script src="../js/base.js" defer></script>
    <script src="../js/page_accueil.js" defer></script>
    <title>Time to Travel</title>
  </head>

  <body>
    <header>
      <!-- Vidéo de fond dans le header -->
      <video autoplay loop muted playsinline disablePictureInPicture id="background-video">
        <source src="../img/video_fond.mp4" type="video/mp4" />
        Votre navigateur ne supporte pas la vidéo.
      </video>

      <!-- Barre de navigation -->
      <?php require_once './partials/nav.php' ?>

      <!-- Formulaire de recherche -->
      <form method="GET" action="./page_de_recherche.php" class="form-recherche">
        <input type="search" name="q" placeholder="Rechercher un voyage..." />
        <button type="submit">🔍</button>
      </form>
    </header>

    <main>

      <!-- Section d’introduction avec les voyages aléatoires -->
      <section class="section-voyages scroll-intro">
        <h2 class="titre-voyages">Envie de partir à l’aventure ?</h2>
        <div class="grid-voyages">
          <!-- Inclusion des cartes de 4 voyages tirés aléatoirement -->
          <?php require_once './get_random_voyages.php'; ?>
        </div>
      </section>

      <!-- Section descriptive du passé -->
      <section id="past">
        <img id="img-past" src="../img/passé.png" alt="Paysage du passé" />
        <aside>
          <h2>Le Passé</h2>
          <p>Et si vous pouviez revivre l’Histoire ?</p>
          <p>Un voyage à travers les siècles vous attend…</p>
          <p>Découvrez ce que vous n’auriez jamais imaginé voir.</p>
          <p>← Cliquez ici pour découvrir les différentes aventure qui vous attendent !</p>
        </aside>
      </section>

      <!-- Section descriptive du futur -->
      <section id="future">
        <aside>
          <h2>Le Futur</h2>
          <p>Et si vous pouviez explorer le futur ?</p>
          <p>Un monde nouveau vous tend les bras…</p>
          <p>Découvrez ce que demain vous réserve, dès aujourd’hui.</p>
          <p>Cliquez ici pour découvrir les voyages du futur les plus fous ! →</p>
        </aside>
        <img id="img-future" src="../img/future.png" alt="Paysage du futur" />
      </section>
    </main>
  </body>
</html>

<?php
// Pied de page (placé après </html> mais sera affiché)
include './partials/footer.php';
?>
