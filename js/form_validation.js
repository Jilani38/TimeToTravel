document.addEventListener('DOMContentLoaded', () => {
  // Gestion toggle mot de passe et compteur
  document.querySelectorAll('.input-password').forEach(container => {
    const input = container.querySelector('input[type="password"], input[type="text"]');
    const btn = container.querySelector('.toggle-password');
    const count = container.querySelector('.char-count');

    btn.addEventListener('click', () => {
      input.type = input.type === 'password' ? 'text' : 'password';
    });

    input.addEventListener('input', () => {
      count.textContent = `${input.value.length} / ${input.maxLength}`;
    });
  });

  // Validation globale des formulaires
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
      let valid = true;
      let messages = [];

      // Email
      const email = form.querySelector('#email');
      if (email && !validateEmail(email.value.trim())) {
        valid = false;
        messages.push("Adresse email invalide.");
      }

      // Mot de passe
      const password = form.querySelector('#motdepasse');
      if (password && password.value.trim().length < 6) {
        valid = false;
        messages.push("Le mot de passe doit contenir au moins 6 caractères.");
      }

      // Confirmation mot de passe (si présent)
      const confirm = form.querySelector('#confirm_mdp');
      if (confirm && password && confirm.value !== password.value) {
        valid = false;
        messages.push("Les mots de passe ne correspondent pas.");
      }

      // Téléphone basique (au moins 8 chiffres)
      const telephone = form.querySelector('#telephone');
      if (telephone && !/^\d{8,}$/.test(telephone.value.trim())) {
        valid = false;
        messages.push("Numéro de téléphone invalide.");
      }

      if (!valid) {
        e.preventDefault();
        alert(messages.join('\n'));
      }
    });
  });
});

// Fonction de validation email simple
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email.toLowerCase());
}
document.addEventListener("DOMContentLoaded", () => {
  const cguCheckbox = document.getElementById("accept-cgu");
  const submitButtons = document.querySelectorAll("form button[type='submit']");

  if (cguCheckbox) {
    // Fonction pour activer/désactiver tous les boutons
    const toggleSubmitButtons = () => {
      submitButtons.forEach(btn => {
        btn.disabled = !cguCheckbox.checked;
      });
    };

    // Applique l’état dès le chargement
    toggleSubmitButtons();

    // Réagit à chaque changement
    cguCheckbox.addEventListener("change", toggleSubmitButtons);
  }
});
