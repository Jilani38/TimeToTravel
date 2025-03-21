<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/page_connexion.css" />
  </head>
  <body>
    <header>
      <nav>
        <!-- <h1>Time to Travel</h1> -->
        <a href="./page_accueil.html">
          <img src="../img/accueil_logo.svg" alt="Time to Travel" />
        </a>

        <div>
          <a href="./page_de_recherche.html">Rechercher </a>
          <a href="./page_admin/index.html">Admin</a>
          <a href="./page_a_propos.html">À propos de nous</a>
          <a href="./page_profil.html">Mon profil</a>
          <a href="./page_connexion.html">Connexion</a>
          <a href="./page_inscription.html">Inscription</a>
        </div>
      </nav>
    </header>

    <div class="login-container">
      <h2>Connecte-toi !</h2>

      <form action="traitement_connexion.php" method="POST">
        <div class="input-group">
          <label for="email">E-mail :</label>
          <input type="email" id="email" name="email" required />
        </div>

        <div class="input-group">
          <label for="mdp">Mot de passe :</label>
          <input type="password" id="mdp" name="mdp" required />
        </div>

        <button type="submit" class="btn-primary">Se connecter</button>
      </form>

      <p class="register-link">
        <a href="page_inscription.html">Je n'ai pas de compte</a>
      </p>
    </div>
  </body>
</html>
