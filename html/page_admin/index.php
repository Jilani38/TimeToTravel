<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../../css/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/base.css" />
    <link rel="stylesheet" href="../../css/page_admin/index.css" />
    <script src="../../js/page_admin/index.js" defer></script>
    <title>Time to Travel - Admin</title>
  </head>

  <body>
    <dialog>
      <img src="" alt="" />
    </dialog>
    <aside>
      <header>
        <a href="./index.html">
          <img src="../../img/logo.svg" alt="Time to Travel" />
        </a>
      </header>
      <nav>
        <a href="./voyages.html">Voyages</a>
        <a href="./utilisateurs.html">Utilisateurs</a>
      </nav>
    </aside>
    <main>
      <h1>Admin</h1>
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Titre</th>
            <th>Date</th>
            <th>Lieu</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Prise de la Bastille</td>
            <td>14 Juillet 1789</td>
            <td>Paris, France</td>
            <td>
              <button
                href="#"
                title="Voir l'image"
                data-image-modal-src="../../img/voyages/prise-bastille.jpeg"
              >
                <i data-lucide="eye"></i>
              </button>
            </td>
            <td>
              <a href="./edit_voyage.html?id=1" title="Modifier">
                <i data-lucide="pencil"></i>
              </a>
              <a href="#" title="Supprimer">
                <i data-lucide="trash-2"></i>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </main>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
      lucide.createIcons();
    </script>
  </body>
</html>
