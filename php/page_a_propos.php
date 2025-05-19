<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>À propos de nous - Time2Travel</title>
  <link rel="stylesheet" href="../css/base.css" />
  <link rel="stylesheet" href="../css/page_a_propos.css" />
  <script src="../js/base.js" defer></script>
</head>
<body>
  <header>
    <?php include './partials/nav.php'; ?>
  </header>

  <main class="apropos-container">
    <section class="intro fade-in">
      <h1>À propos de Time2Travel</h1>
      <p>
        Time2Travel inc est née d’une découverte révolutionnaire, d’une vision audacieuse et de la volonté de repousser les frontières du temps.
      </p>
    </section>

    <section class="notre-histoire slide-in">
      <h2>Notre histoire</h2>
      <p>
        Tout a commencé en 2015, en Afrique du Sud, lorsqu’une équipe de géologues a découvert un minéral jusqu’alors inconnu : le Jhi.
        Ce cristal d’apparence anodine s’est révélé posséder des propriétés extraordinaires, défiant les lois du temps.
        Pendant des années, chercheurs et physiciens ont étudié ses caractéristiques uniques, jusqu’au jour où, grâce à une avancée révolutionnaire en 2021, le premier voyage temporel contrôlé a été réalisé avec succès.
      </p>
      <p>
        Face à ce potentiel inédit, nous avons fondé ChronoVoyages avec une mission claire : explorer et sécuriser les gisements de Jhi pour démocratiser l’accès au voyage dans le temps.
        Aujourd’hui, nous sommes fiers d’être la première entreprise française à offrir cette expérience unique à nos clients.
      </p>
      <p>
        En 2025, nous vous proposons <strong>21 destinations exclusives</strong> :
        <br>🔹 Des voyages dans le <strong>passé</strong>, pour revivre les moments les plus fascinants de l’histoire.
        <br>🔹 Des incursions dans le <strong>futur</strong>, pour entrevoir les mystères de demain.
        <br>🔹 Et même une aventure dans l’<strong>ère des dinosaures</strong>, pour remonter aux origines.
      </p>
      <p>
        Avec Time2Travel, le temps n’est plus une limite, mais une aventure.
      </p>
    </section>

    <section class="equipe fade-in">
      <h2>Notre équipe</h2>
      <ul>
        <li><strong>Jilani</strong> — Fondateur & PDG, visionnaire du voyage temporel</li>
        <li><strong>Francisco</strong> — Directeur des Expériences Temporelles, créateur d’aventures inoubliables</li>
        <li><strong>Paul</strong> — Responsable Innovation & Systèmes, architecte de la technologie temporelle</li>
      </ul>
    </section>

    <section class="valeurs slide-in">
      <h2>Nos valeurs</h2>
      <div class="valeurs-grid">
        <div class="valeur-card">
          <h3>Innovation</h3>
          <p>Nous repoussons les limites du possible avec chaque nouvelle destination temporelle.</p>
        </div>
        <div class="valeur-card">
          <h3>Sécurité</h3>
          <p>Chaque itinéraire est validé par nos équipes pour garantir une expérience sans risque.</p>
        </div>
        <div class="valeur-card">
          <h3>Accessibilité</h3>
          <p>Notre ambition : rendre le voyage dans le temps accessible à tous.</p>
        </div>
      </div>
    </section>

    <section class="cgu fade-in">
      <h2>Conditions Générales d’Utilisation (CGU)</h2>
      <p>
        L’usage des services de Time2Travel inc est soumis à nos conditions générales d’utilisation. Pour garantir une expérience transparente et éthique,
        nous vous invitons à consulter le document officiel :
      </p>
      <a class="btn-cgu" href="../data/CGU_T2T.pdf" target="_blank">📄 Consulter les CGU complètes (PDF)</a>
    </section>

    <section class="contact slide-in">
      <h2>Contact & Réseaux</h2>
      <p>📧 Email : <a href="mailto:contact@t2t.com">contact@t2t.com</a></p>
      <p>🌍 Siège : Time2Travel inc, Paris, France</p>
      <p>📱 Suivez-nous sur Instagram, TikTok, et LinkedIn pour découvrir les coulisses de l’aventure temporelle !</p>
    </section>

    <section class="cta fade-in">
      <h2>Envie de nous rejoindre ?</h2>
      <p>Intégrez l’équipe, devenez voyageur VIP ou investissez dans le futur : l’aventure ne fait que commencer.</p>
      <a href="./page_inscription.php" class="btn-inscription">🚀 Devenir un VIP Traveleur</a>
    </section>
  </main>

  <footer>
    <?php include './partials/footer.php'; ?>
  </footer>

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
