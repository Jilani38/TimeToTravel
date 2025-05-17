<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../page_accueil.php');
  exit;
}

if (!isset($_GET['id'])) {
  header('Location: ./index.php');
  exit;
}

$voyages = json_decode(file_get_contents('../../data/voyages.json'), true);
$id = $_GET['id'];

$index = null;
foreach ($voyages as $key => $v) {
  if ((string)$v['id'] === (string)$id) {
    $index = $key;
    break;
  }
}

if ($index === null) {
  header('Location: ./index.php');
  exit;
}

$voyage = $voyages[$index];

if (isset($_POST['submit'])) {
  $voyages[$index] = [
    "id" => $voyage['id'],
    "titre" => $_POST['titre'],
    "image" => $voyage['image'],
    "duree" => (int) $_POST['duree'],
    "description" => $_POST['description'],
    "type_temporel" => $_POST['type_temporel'],
    "lieu" => $_POST['lieu'],
    "date_depart_personnalisable" => $_POST['date_depart_personnalisable'],
    "prix_base" => (int) $_POST['prix_base'],
    "programme" => $_POST['programme'] ?? [],
    "options" => $_POST['options'] ?? [],
    "activites_incluses" => $_POST['activites'] ?? [],
    "niveau_difficulte" => $_POST['niveau_difficulte'],
    "public_cible" => $_POST['public_cible'] ?? [],
    "note_moyenne" => (float) ($_POST['note_moyenne'] ?? 0),
    "nombre_avis" => (int) ($_POST['nombre_avis'] ?? 0),
    "infos_pratiques" => $_POST['infos_pratiques'] ?? [],
    "conditions_annulation" => $_POST['conditions_annulation'],
    "theme" => $_POST['theme']
  ];

  if (!empty($_FILES['image']['name'])) {
    $info = pathinfo($_FILES['image']['name']);
    $extension = strtolower($info['extension']);

    if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
      $filename = sprintf('%s.%s', $voyage['id'], $extension);
      move_uploaded_file($_FILES['image']['tmp_name'], '../../data/images/' . $filename);
      $voyages[$index]['image'] = $filename;
    } else {
      exit('Erreur : format invalide. Veuillez charger une image PNG ou JPEG.');
    }
  }

  file_put_contents('../../data/voyages.json', json_encode($voyages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: ./index.php?updated=1');
  exit;
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../css/base.css">
  <link rel="stylesheet" href="../../css/page_admin/base.css">
  <link rel="stylesheet" href="../../css/page_admin/edit_voyage.css">
  <script src="../../js/page_admin/edit_voyage.js" defer></script>
  <title>Modifier un voyage</title>
</head>
<body>
  <?php require '../partials/admin-nav.php'; ?>
  <main>
    <h1>Modifier le voyage</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <table>
        <tr><th>Titre</th><td><input type="text" name="titre" value="<?= htmlspecialchars($voyage['titre']) ?>" required></td></tr>
        <tr><th>Image</th>
          <td>
            <input type="file" name="image" accept="image/*">
            <img src="../../data/images/<?= htmlspecialchars($voyage['image']) ?>" alt="<?= htmlspecialchars($voyage['titre']) ?>" style="max-height: 120px; margin-top: 10px;">
          </td>
        </tr>
        <tr><th>Durée</th><td><input type="number" name="duree" id="duree" value="<?= $voyage['duree'] ?>" required></td></tr>
        <tr><th>Description</th><td><textarea name="description" required><?= htmlspecialchars($voyage['description']) ?></textarea></td></tr>
        <tr><th>Type temporel</th>
          <td>
            <label><input type="radio" name="type_temporel" value="passé" <?= $voyage['type_temporel'] === 'passé' ? 'checked' : '' ?>> Passé</label>
            <label><input type="radio" name="type_temporel" value="futur" <?= $voyage['type_temporel'] === 'futur' ? 'checked' : '' ?>> Futur</label>
          </td>
        </tr>
        <tr><th>Lieu</th><td><input type="text" name="lieu" value="<?= htmlspecialchars($voyage['lieu']) ?>" required></td></tr>
        <tr><th>Date de départ personnalisable</th><td><input type="checkbox" name="date_depart_personnalisable" <?= $voyage['date_depart_personnalisable'] ? 'checked' : '' ?>></td></tr>
        <tr><th>Prix de base</th><td><input type="number" name="prix_base" value="<?= $voyage['prix_base'] ?>" required></td></tr>
        <tr><th>Niveau de difficulté</th>
          <td>
            <select name="niveau_difficulte">
              <option value="facile" <?= $voyage['niveau_difficulte'] === 'facile' ? 'selected' : '' ?>>Facile</option>
              <option value="intermédiaire" <?= $voyage['niveau_difficulte'] === 'intermédiaire' ? 'selected' : '' ?>>Intermédiaire</option>
              <option value="difficile" <?= $voyage['niveau_difficulte'] === 'difficile' ? 'selected' : '' ?>>Difficile</option>
            </select>
          </td>
        </tr>
        <tr><th>Public cible</th>
          <td>
            <?php
              $options = ["enfants", "adultes", "seniors", "tout public"];
              foreach ($options as $opt) {
                $checked = in_array($opt, $voyage['public_cible']) ? 'checked' : '';
                echo "<label><input type='checkbox' name='public_cible[]' value='$opt' $checked> $opt</label> ";
              }
            ?>
          </td>
        </tr>
        <tr><th>Note moyenne</th><td><input type="number" name="note_moyenne" step="0.1" value="<?= $voyage['note_moyenne'] ?>"></td></tr>
        <tr><th>Nombre d'avis</th><td><input type="number" name="nombre_avis" value="<?= $voyage['nombre_avis'] ?>"></td></tr>
        <tr><th>Conditions d'annulation</th><td><textarea name="conditions_annulation" required><?= htmlspecialchars($voyage['conditions_annulation']) ?></textarea></td></tr>
        <tr><th>Thème</th><td><input type="text" name="theme" value="<?= htmlspecialchars($voyage['theme']) ?>" required></td></tr>
      </table>

      <section>
        <h2>Infos pratiques</h2>
        <div id="infos-container">
          <?php foreach ($voyage['infos_pratiques'] as $info): ?>
            <div class="info-bloc">
              <input type="text" name="infos_pratiques[]" value="<?= htmlspecialchars($info) ?>">
              <button type="button" onclick="this.parentElement.remove()">❌ Supprimer</button>
              <hr>
            </div>
          <?php endforeach; ?>
        </div>
        <button type="button" onclick="ajouterInfo()">Ajouter une info</button>
      </section>

      <section>
        <h2>Programme</h2>
        <div id="programme-container" data-programme='<?= json_encode($voyage['programme'], JSON_UNESCAPED_UNICODE) ?>'></div>
      </section>

      <section>
        <h2>Options disponibles</h2>
        <div id="options-container" data-options='<?= json_encode($voyage['options'], JSON_UNESCAPED_UNICODE) ?>'></div>
        <button type="button" onclick="ajouterOption()">Ajouter une option</button>
      </section>

      <section>
        <h2>Activités incluses</h2>
        <div id="activites-container" data-activites='<?= json_encode($voyage['activites_incluses'], JSON_UNESCAPED_UNICODE) ?>'></div>
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
