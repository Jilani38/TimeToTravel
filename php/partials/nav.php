<nav>
  <a href="./page_accueil.php">
    <img src="../img/accueil_logo.svg" alt="Time to Travel" />
  </a>

  <div>
    <a href="./page_de_recherche.php">Rechercher</a>
    <a href="./page_destination.php">Destination</a>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <a href="./page_admin/index.php">Gestion des voyages</a>
    <?php else: ?>
      <a href="./page_a_propos.php">À propos de nous</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['id'])): ?>
      <a href="./dashboard.php">Mon profil</a>
      <a href="./deconnexion.php">Déconnexion</a>
      <a href="./page_panier.php">
        <img src="../img/panier_blanc.png" alt="panier" class="icone-panier" />
      </a>
    <?php else: ?>
      <a href="./page_connexion.php">Connexion</a>
      <a href="./page_inscription.php">Inscription</a>
    <?php endif; ?>

    <button id="toggle-dark-mode">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon-icon lucide-moon"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
    </button>
  </div>
</nav>
