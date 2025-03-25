<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/page_profil.css" />
    <title>Mon profil</title>
  </head>
  <body>
    <header>
      <nav>
        <!-- <h1>Time to Travel</h1> -->
        <a href="./page_accueil.php">
          <img src="../img/accueil_logo.svg" alt="Time to Travel" />
        </a>

        <div></div>
      </nav>
    </header>
    <div class="profil-container">
      <h1>Mon profil</h1>

      <form id="profil">
        <label for="nom">Nom : </label>
        <input type="text" id="nom" name="nom" value="nom" />

        <label for="prenom">Prénom : </label>
        <input type="text" id="prenom" name="prenom" value="prénom" />

        <label for="email">Email : </label>
        <input type="email" id="email" name="email" value="email@exemple.fr" />

        <label for="mdp">Mot de Passe : </label>
        <input type="password" id="mdp" name="mdp" value="blablabla" />

        <label for="age">Age : </label>
        <input type="date" id="age" name="age" value="2006-10-09" />

        <label for="tel">Téléphone : </label>
        <input type="tel" id="tel" name="tel" value="06 56 90 50 94" />

        <!-- <button type="submit" class="btn-primary">Enregistrer</button>
        <button type="reset" class="btn-secondary">Annuler</button> -->
      </form>
    </div>

    <script src="../js/profil.js"></script>
  </body>
</html>
