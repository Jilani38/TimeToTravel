<?php
// Démarre la session (utile si des éléments comme le nom ou le rôle utilisateur sont affichés dans la navigation)
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>À propos de nous - Time2Travel</title>
  <!-- Feuilles de style -->
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/page_a_propos.css" />
  <!-- Script JS global -->
  <script src="../js/base.js" defer></script>
</head>
<body>
  <header>
    <!-- Inclusion de la barre de navigation -->
    <?php include './partials/nav.php'; ?>
  </header>

  <main class="apropos-container">
    <!-- Section d’introduction -->
    <section class="intro fade-in">
      <h1>À propos de Time2Travel</h1>
      <p>
        Time2Travel inc est née d’une découverte révolutionnaire, d’une vision audacieuse et de la volonté de repousser les frontières du temps.
      </p>
    </section>

    <!-- Section sur l’histoire de l’entreprise -->
    <section class="notre-histoire slide-in">
      <h2>Notre histoire</h2>
      <p>
        Tout a commencé en 2015, en Afrique du Sud, lorsqu’une équipe de géologues a découvert un minéral jusqu’alors inconnu : le Jhi...
      </p>
      <p>
        Face à ce potentiel inédit, nous avons fondé Time 2 Travel avec une mission claire...
      </p>
      <p>
        En 2025, nous vous proposons 21 destinations exclusives :
        <!-- Liste de types de voyages -->
        <br>🔹 Passé
        <br>🔹 Futur
        <br>🔹 Dinosaures
      </p>
      <p>
        Avec Time2Travel, le temps n’est plus une limite, mais une aventure.
      </p>
    </section>

    <!-- Section sur les membres de l’équipe -->
    <section class="equipe fade-in">
      <h2>Notre équipe</h2>
      <ul>
        <li><strong>Jilani</strong> — Fondateur & PDG</li>
        <li><strong>Francisco</strong> — Directeur des Expériences</li>
        <li><strong>Paul</strong> — Responsable Innovation</li>
      </ul>
    </section>

    <!-- Section sur les valeurs de l’entreprise -->
    <section class="valeurs slide-in">
      <h2>Nos valeurs</h2>
      <div class="valeurs-grid">
        <div class="valeur-card">
          <h3>Innovation</h3>
          <p>Nous repoussons les limites du possible...</p>
        </div>
        <div class="valeur-card">
          <h3>Sécurité</h3>
          <p>Chaque itinéraire est validé pour garantir une expérience sans risque.</p>
        </div>
        <div class="valeur-card">
          <h3>Accessibilité</h3>
          <p>Notre ambition : rendre le voyage dans le temps accessible à tous.</p>
        </div>
      </div>
    </section>

    <!-- Section CGU avec lien vers PDF -->
    <section class="cgu fade-in">
      <h2>Conditions Générales d’Utilisation (CGU)</h2>
      <p>
        L’usage des services de Time2Travel inc est soumis à nos CGU.
      </p>
      <a class="btn-cgu" href="../data/CGU_T2T.pdf" target="_blank">📄 Consulter les CGU complètes (PDF)</a>
    </section>

    <!-- Section de contact -->
    <section class="contact slide-in">
      <h2>Contact & Réseaux</h2>
      <p>📧 Email : <a href="mailto:contact@t2t.com">contact@t2t.com</a></p>
      <p>🌍 Siège : Time2Travel inc, Paris, France</p>
      <p>📱 Réseaux sociaux : Instagram, TikTok, LinkedIn</p>
    </section>

    <!-- Appel à action pour devenir membre VIP -->
    <section class="cta fade-in">
      <h2>Envie de nous rejoindre ?</h2>
      <p>Intégrez l’équipe, devenez voyageur VIP ou investissez...</p>
      <a href="./page_inscription.php" class="btn-inscription">🚀 Devenir un VIP Traveleur</a>
    </section>
  </main>

  <footer>
    <!-- Inclusion du pied de page -->
    <?php include './partials/footer.php'; ?>
  </footer>

  <!-- Animation au scroll des sections -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const sections = document.querySelectorAll(".fade-in, .slide-in");

      const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            obs.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      sections.forEach(section => observer.observe(section));
    });
  </script>
</body>
</html>
