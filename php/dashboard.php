<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: page_connexion.php");
  exit();
}

$utilisateurs = json_decode(file_get_contents("../data/utilisateurs.json"), true);
$utilisateur = null;
foreach ($utilisateurs as $u) {
  if ($u['id'] === $_SESSION['id']) {
    $utilisateur = $u;
    break;
  }
}

if (!$utilisateur) {
  die("Utilisateur non trouvé.");
}

$commandes = $utilisateur['commandes'] ?? [];
$role = $utilisateur['role'] ?? 'client';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon tableau de bord</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/dashboard.css">
  <script defer src="../js/base.js"></script>
  <script defer src="../js/dashboard.js"></script>
</head>
<body>
  <header>
    <?php require_once './partials/nav.php'; ?>
  </header>

  <main class="card dashboard">
    <h1>Bienvenue, <?= htmlspecialchars($utilisateur['prenom']) ?> !</h1>

    <?php if ($role === 'client'): ?>
      <a href="page_paiement_vip.php" class="btn-vip">
       👑 Devenir VIP Traveleur pour 1500 € et bénéficier de -10% sur vos commandes
      </a>


    <?php elseif ($role === 'vip'): ?>
      <div class="btn-vip-message">
        ✨ Vous êtes un VIP Traveller !
      </div>
    <?php endif; ?>

    <div class="onglets">
      <button class="bbtn-primary onglet-actif" data-target="#profil">Mon profil</button>
      <button data-target="#commandes">Mes commandes</button>
    </div>

    <section id="profil" class="onglet-section actif">
      <h2>Informations personnelles</h2>
      <form method="POST" action="update_profil.php">
      <ul class="profil-inline">
        <?php 
        $infos = [
          "nom" => "Nom",
          "prenom" => "Prénom",
          "email" => "Email",
          "telephone" => "Téléphone",
          "date_naissance" => "Date de naissance",
          "genre" => "Genre",
          "date_inscription" => "Inscrit depuis",
          "derniere_connexion" => "Dernière connexion"
        ];
        foreach ($infos as $champ => $label):
          $readonly = in_array($champ, ["email", "date_inscription", "derniere_connexion"]) ? 'readonly' : '';
        ?>
          <li>
            <label><?= $label ?> :</label>
            <input type="text" name="<?= $champ ?>" id="<?= $champ ?>" value="<?= htmlspecialchars($utilisateur[$champ]) ?>" readonly>
            <?php if (!in_array($champ, ["date_inscription", "derniere_connexion"])): ?>
              <button type="button" class="btn-edit">✏️</button>
              <button type="button" class="btn-valider" style="display:none;">✅</button>
              <button type="button" class="btn-annuler" style="display:none;">❌</button>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>

        <button id="btn-enregistrer" class="btn-primary" style="display:none;">💾 Enregistrer les modifications</button>
      </form>
    </section>

    <section id="commandes" class="onglet-section">
      <h2>Mes voyages réservés</h2>
      <?php if (empty($commandes)): ?>
        <p>Vous n'avez pas encore passé de commande.</p>
      <?php else: ?>
        <div class="cartes-commandes">
          <?php foreach ($commandes as $c): ?>
            <div class="carte-commande">
              <h3><?= htmlspecialchars($c['titre']) ?></h3>
              <p><strong>Date de commande :</strong> <?= htmlspecialchars($c['date']) ?></p>
              <?php if (!empty($c['date_depart'])): ?>
                <p><strong>Date de départ :</strong> <?= htmlspecialchars($c['date_depart']) ?></p>
              <?php endif; ?>
              <p><strong>Voyageurs :</strong> <?= (int)$c['voyageurs'] ?></p>

              <?php if (!empty($c['options'])): ?>
                <p><strong>Options :</strong></p>
                <div class="options-lignes">
                  <?php foreach ($c['options'] as $opt): ?>
                    <div class="opt-ligne">
                      <?= htmlspecialchars($opt['nom']) ?> · Qté <?= $opt['quantite'] ?> · <?= $opt['total_option'] ?> €
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <p><strong>Montant total :</strong> <?= $c['total'] ?> €</p>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>

<?php include './partials/footer.php'; ?>
