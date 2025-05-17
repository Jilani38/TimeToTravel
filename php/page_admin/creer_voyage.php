<script>
  console.log("JS chargé !");
</script>



<?php
if (isset($_POST['submit'])) {
  $voyages = json_decode(file_get_contents('../../data/voyages.json'), true);
  if (!is_array($voyages)) $voyages = [];

  $nouvel_id = empty($voyages) ? 1 : max(array_column($voyages, 'id')) + 1;

  // Image
  $image_filename = '';
  if (!empty($_FILES['image']['name'])) {
    $info = pathinfo($_FILES['image']['name']);
    $image_filename = $nouvel_id . '.' . $info['extension'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../../data/images/' . $image_filename);
  }

  $voyage = [
    "id" => $nouvel_id,
    "titre" => $_POST['titre'],
    "image" => $image_filename,
    "duree" => (int) $_POST['duree'],
    "description" => $_POST['description'],
    "prix_base" => (int) $_POST['prix_base'],
    "type_temporel" => $_POST['type_temporel'],
    "niveau_difficulte" => $_POST['niveau_difficulte'],
    "note_moyenne" => (float) ($_POST['note_moyenne'] ?? 0),
    "nombre_avis" => (int) ($_POST['nombre_avis'] ?? 0),
    "public_cible" => $_POST['public_cible'] ?? [],
    "infos_pratiques" => $_POST['infos_pratiques'] ?? [],
    "programme" => [],
    "options" => [],
    "activites_incluses" => []
  ];

  $voyages[] = $voyage;
  file_put_contents('../../data/voyages.json', json_encode($voyages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: ./index.php?created=1');
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Créer un voyage - Time2Travel</title>
  <link rel="stylesheet" href="../../css/base.css">
  <link rel="stylesheet" href="../../css/page_admin/base.css">
  <link rel="stylesheet" href="../../css/page_admin/edit_voyage.css">
  <script defer src="../../js/page_admin/creer_voyages.js"></script>
</head>
<body>

<?php require '../partials/admin-nav.php'; ?>

<main>
  <h1>Créer un nouveau voyage</h1>
  <form action="" method="post" enctype="multipart/form-data">
    <table>
      <tr><th>Titre</th><td><input type="text" name="titre" required></td></tr>
      <tr><th>Image</th><td><input type="file" name="image" accept="image/*" required></td></tr>
      <tr><th>Durée</th><td><input type="number" name="duree" id="duree" min="1" required></td></tr>
      <tr><th>Spécificités</th><td><textarea name="description" required></textarea></td></tr>
      <tr><th>Prix total</th><td><input type="number" name="prix_base" required></td></tr>
      <tr><th>Type temporel</th>
          <td>
            <label><input type="radio" name="type_temporel" value="passé" checked> Passé</label>
            <label><input type="radio" name="type_temporel" value="futur"> Futur</label>
          </td>
      </tr>
      <tr><th>Niveau de difficulté</th>
          <td>
            <select name="niveau_difficulte">
              <option value="facile">Facile</option>
              <option value="intermédiaire">Intermédiaire</option>
              <option value="difficile">Difficile</option>
            </select>
          </td>
      </tr>
      <tr><th>Note moyenne</th><td><input type="number" name="note_moyenne" step="0.1"></td></tr>
      <tr><th>Nombre d'avis</th><td><input type="number" name="nombre_avis"></td></tr>
      <tr><th>Public cible</th>
          <td>
            <label><input type="checkbox" name="public_cible[]" value="enfants"> Enfants</label>
            <label><input type="checkbox" name="public_cible[]" value="adultes"> Adultes</label>
            <label><input type="checkbox" name="public_cible[]" value="seniors"> Seniors</label>
            <label><input type="checkbox" name="public_cible[]" value="tout public"> Tout public</label>
          </td>
      </tr>
    </table>

    <section>
      <h2>Infos pratiques</h2>
      <div id="infos-container"></div>
      <button type="button" onclick="ajouterInfo()">Ajouter une info</button>
    </section>

    <section>
      <h2>Programme (généré dynamiquement)</h2>
      <div id="programme-container"></div>
    </section>

    <section>
      <h2>Options disponibles</h2>
      <div id="options-container"></div>
      <button type="button" onclick="ajouterOption()">Ajouter une option</button>
    </section>

    <section>
      <h2>Activités incluses</h2>
      <div id="activites-container"></div>
      <button type="button" onclick="ajouterActivite()">Ajouter une activité</button>
    </section>

    <div>
      <input type="submit" name="submit" value="Enregistrer">
      <a href="./index.php">Annuler</a>
    </div>
  </form>
</main>

</body>
</html>
