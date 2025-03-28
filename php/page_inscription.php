<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="../css/page_inscription.css" />
  </head>

  <body>
    <header>
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
    </header>

    <form action="" method="post">
      <legend>Inscris-toi !</legend>

      <div class="input-group">
        <label for="fp">Prénom :</label>
        <input type="text" id="fp" name="fp" required />
      </div>

      <div class="input-group">
        <label for="fm">Nom :</label>
        <input type="text" id="fm" name="fm" required />
      </div>

      <div class="input-group">
        <label for="date">Date de naissance :</label>
        <input
          type="date"
          id="date"
          name="date"
          value="2003-12-23"
          max="2007-01-01"
          required
        />
      </div>

      <div class="input-group">
        <label>Genre :</label>
        <div class="radio-group">
          <input type="radio" id="homme" name="g" value="Homme" checked />
          <label for="homme">Homme</label>
          <input type="radio" id="femme" name="g" value="Femme" />
          <label for="femme">Femme</label>
        </div>
      </div>

      <div class="input-group">
        <label for="em">Adresse mail :</label>
        <input type="email" id="em" name="em" required />
      </div>

      <div class="input-group">
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" required />
      </div>

      <button type="submit" class="btn-primary">Créer mon compte</button>
      <a href="page_connexion.php" class="btn-secondary">
        J'ai déjà un compte
      </a>
    </form>
  </body>
</html>
