<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../../css/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/edit_voyage.css" />
    <title>Time to Travel - Edit Voyage</title>
  </head>

  <body>
    <aside>
      <header>
        <a href="./index.php">
          <img src="../../img/logo.svg" alt="Time to Travel" />
        </a>
      </header>
      <nav>
        <a href="./voyages.php">Voyages</a>
        <a href="./utilisateurs.php">Utilisateurs</a>
      </nav>
    </aside>
    <main>
      <table>
        <tr>
          <th>Titre</th>
          <td>
            <input type="text" value="Prise de la Bastille" />
          </td>
        </tr>
        <tr>
          <th>Date</th>
          <td>
            <input type="date" value="1789-07-14" />
          </td>
        </tr>
        <tr>
          <th>Lieu</th>
          <td>
            <input type="text" value="Paris, France" />
          </td>
        </tr>
        <tr>
          <th>Image</th>
          <td>
            <input type="file" accept="image/*" />
            <img
              src="../../img/voyages/prise-bastille.jpeg"
              alt="Prise de la Bastille"
            />
          </td>
        </tr>
      </table>
      <div>
        <a href="./index.php">Enregistrer</a>
        <a href="./index.php">Annuler</a>
      </div>
    </main>
  </body>
</html>
