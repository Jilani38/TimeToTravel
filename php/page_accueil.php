<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/page_accueil.css" />
    <script src="../js/page_accueil.js" defer></script>
    <title>Time to Travel</title>
  </head>

  <body>
    <header>
      <video autoplay loop muted playsinline id="background-video">
        <source src="../img/video_fond.mp4" type="video/mp4" />
        Votre navigateur ne supporte pas la vidéo.
      </video>
      <nav>
        <!-- <h1>Time to Travel</h1> -->
        <a href="./page_accueil.php">
          <img src="../img/accueil_logo.svg" alt="Time to Travel" />
        </a>

        <div>
          <a href="./page_de_recherche.php">Rechercher </a>
          <a href="./page_admin/index.php">Admin</a>
          <a href="./page_a_propos.php">À propos de nous</a>
          <a href="./page_profil.php">Mon profil</a>
          <a href="./page_connexion.php">Connexion</a>
          <a href="./page_inscription.php">Inscription</a>
          
        </div>
      </nav>
      <input type="search" placeholder="Rechercher" />
    </header>
    <main>
      <section id="choice">
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
