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
    move_uploaded_file($_FILES['image']['tmp_name'], '../../img/' . $image_filename);
  }

  $voyage = [
    "id" => $nouvel_id,
    "titre" => $_POST['titre'],
    "image" => $image_filename,
    "duree" => (int) $_POST['duree'],
    "specificites" => $_POST['specificites'],
    "prix_total" => (int) $_POST['prix_total'],
    "etapes" => [
      [
        "titre" => $_POST['etape_titre'],
        "date_arrivee" => $_POST['date_arrivee'],
        "date_depart" => $_POST['date_depart'],
        "duree" => (int) $_POST['etape_duree'],
        "position" => [
          "gps" => $_POST['gps'],
          "nom_lieu" => $_POST['lieu']
        ],
        "options" => [
          [
            "type" => $_POST['option_type'],
            "nom" => $_POST['option_nom'],
            "prix_par_personne" => (int) $_POST['option_prix']
          ]
        ]
      ]
    ],
    "activites" => [
      [
        "nom" => $_POST['activite_nom'],
        "description" => $_POST['activite_description'],
        "prix" => (int) $_POST['activite_prix']
      ]
    ]
  ];

  $voyages[] = $voyage;
  file_put_contents('../../data/voyages.json', json_encode($voyages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
  header('Location: ./index.php');
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
</head>
<body>

  <aside>
    <header>
      <a href="./index.php">
        <img src="../../img/logo.svg" alt="Time to Travel" />
      </a>
    </header>
    <nav>
      <a href="./index.php">Voyages</a>
      <a href="./utilisateur.php">Utilisateurs</a>
    </nav>
  </aside>

  <main>
    <h1>Créer un nouveau voyage</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <table>
        <tr><th>Titre</th><td><input type="text" name="titre" required></td></tr>
        <tr><th>Image</th><td><input type="file" name="image" accept="image/*" required></td></tr>
        <tr><th>Durée (total)</th><td><input type="number" name="duree" required></td></tr>
        <tr><th>Spécificités</th><td><textarea name="specificites" required></textarea></td></tr>
        <tr><th>Prix total</th><td><input type="number" name="prix_total" required></td></tr>

        <tr><th colspan="2">🧭 Étape</th></tr>
        <tr><th>Titre</th><td><input type="text" name="etape_titre" required></td></tr>
        <tr><th>Date arrivée</th><td><input type="date" name="date_arrivee" required></td></tr>
        <tr><th>Date départ</th><td><input type="date" name="date_depart" required></td></tr>
        <tr><th>Durée</th><td><input type="number" name="etape_duree" required></td></tr>
        <tr><th>Lieu</th><td><input type="text" name="lieu" required></td></tr>
        <tr><th>GPS</th><td><input type="text" name="gps" placeholder="0.0000, 0.0000" required></td></tr>

        <tr><th colspan="2">🏨 Option</th></tr>
        <tr><th>Type</th><td><input type="text" name="option_type" required></td></tr>
        <tr><th>Nom</th><td><input type="text" name="option_nom" required></td></tr>
        <tr><th>Prix par personne</th><td><input type="number" name="option_prix" required></td></tr>

        <tr><th colspan="2">🎯 Activité</th></tr>
        <tr><th>Nom</th><td><input type="text" name="activite_nom" required></td></tr>
        <tr><th>Description</th><td><textarea name="activite_description" required></textarea></td></tr>
        <tr><th>Prix</th><td><input type="number" name="activite_prix" required></td></tr>
      </table>

      <div>
        <input type="submit" name="submit" value="Enregistrer">
        <a href="./index.php">Annuler</a>
      </div>
    </form>
  </main>

</body>
</html>
