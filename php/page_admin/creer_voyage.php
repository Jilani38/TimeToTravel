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

  // PROGRAMME
  $programme = [];
  if (!empty($_POST['programme']) && is_array($_POST['programme'])) {
    foreach ($_POST['programme'] as $index => $etape) {
      $programme[] = [
        "jour" => (int) $index,
        "titre" => trim($etape['titre'] ?? ''),
        "activite" => trim($etape['activite'] ?? '')
      ];
    }
  }

  // OPTIONS : nettoyage des prix < 0
  $options = [];
  if (!empty($_POST['options']) && is_array($_POST['options'])) {
    foreach ($_POST['options'] as $opt) {
      $prix = max(0, (int)($opt['prix_par_personne'] ?? 0));
      $options[] = [
        "type" => $opt['type'] ?? '',
        "nom" => $opt['nom'] ?? '',
        "prix_par_personne" => $prix
      ];
    }
  }

  // ACTIVITÉS INCLUSES
  $activites = [];
  if (!empty($_POST['activites_incluses']) && is_array($_POST['activites_incluses'])) {
    foreach ($_POST['activites_incluses'] as $act) {
      $activites[] = [
        "nom" => trim($act['nom'] ?? ''),
        "description" => trim($act['description'] ?? '')
      ];
    }
  }

  // Champs numériques sécurisés
  $prix_base = max(0, (int) $_POST['prix_base']);
  $note_moyenne = min(5, max(0, (float) ($_POST['note_moyenne'] ?? 0)));
  $nombre_avis = max(0, (int) ($_POST['nombre_avis'] ?? 0));
  $duree = max(1, (int) $_POST['duree']);

  $voyage = [
    "id" => $nouvel_id,
    "titre" => $_POST['titre'],
    "image" => $image_filename,
    "duree" => $duree,
    "description" => $_POST['description'],
    "type_temporel" => $_POST['type_temporel'],
    "lieu" => $_POST['lieu'] ?? '',
    "date_depart_personnalisable" => true,
    "prix_base" => $prix_base,
    "programme" => $programme,
    "options" => $options,
    "activites_incluses" => $activites,
    "niveau_difficulte" => $_POST['niveau_difficulte'],
    "public_cible" => $_POST['public_cible'] ?? [],
    "note_moyenne" => $note_moyenne,
    "nombre_avis" => $nombre_avis,
    "infos_pratiques" => $_POST['infos_pratiques'] ?? [],
    "conditions_annulation" => "Annulation gratuite jusqu’à 48h avant le départ.",
    "theme" => $_POST['theme'] ?? ''
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
      <tr><th>Description</th><td><textarea name="description" required></textarea></td></tr>
      <tr><th>Type temporel</th>
        <td>
          <label><input type="radio" name="type_temporel" value="passé" checked> Passé</label>
          <label><input type="radio" name="type_temporel" value="futur"> Futur</label>
        </td>
      </tr>
      <tr><th>Lieu</th><td><input type="text" name="lieu" required></td></tr>
      <tr><th>Prix total</th><td><input type="number" name="prix_base" min="0" required></td></tr>
      <tr><th>Niveau de difficulté</th>
        <td>
          <select name="niveau_difficulte">
            <option value="facile">Facile</option>
            <option value="intermédiaire">Intermédiaire</option>
            <option value="modéré">Modéré</option>
            <option value="difficile">Difficile</option>
          </select>
        </td>
      </tr>
      <tr><th>Public cible</th>
        <td>
          <label><input type="checkbox" name="public_cible[]" value="étudiants"> Étudiants</label>
          <label><input type="checkbox" name="public_cible[]" value="familles"> Familles</label>
          <label><input type="checkbox" name="public_cible[]" value="curieux d'histoire"> Curieux d'histoire</label>
          <label><input type="checkbox" name="public_cible[]" value="aventuriers"> Aventuriers</label>
          <label><input type="checkbox" name="public_cible[]" value="passionnés de science-fiction"> Passionnés de science-fiction</label>
          <label><input type="checkbox" name="public_cible[]" value="personnes âgées"> Personnes âgées</label>
          <label><input type="checkbox" name="public_cible[]" value="voyageurs solo"> Voyageurs solo</label>
          <label><input type="checkbox" name="public_cible[]" value="groupes scolaires"> Groupes scolaires</label>
          <label><input type="checkbox" name="public_cible[]" value="grand public"> Grand public</label>
        </td>
      </tr>
      <tr><th>Note moyenne</th><td><input type="number" name="note_moyenne" step="0.1" min="0" max="5"></td></tr>
      <tr><th>Nombre d'avis</th><td><input type="number" name="nombre_avis" min="0"></td></tr>
      <tr><th>Thème</th><td><input type="text" name="theme"></td></tr>
    </table>

    <section>
      <h2>Infos pratiques</h2>
      <div id="infos-container"></div>
      <button type="button" onclick="ajouterInfo()">Ajouter une info</button>
    </section>

    <section>
      <h2>Programme</h2>
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
