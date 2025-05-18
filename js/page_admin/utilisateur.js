document.addEventListener('DOMContentLoaded', () => {
  const userIdSession = document.body.dataset.userId;

  // --- Bannir / débannir ---
  document.querySelectorAll('.btn-bannir').forEach(button => {
    button.addEventListener('click', () => {
      const row = button.closest('tr');
      const userId = row.dataset.userId;
      const roleCell = row.querySelector('.role');
      const roleActuel = roleCell.textContent.trim();

      if (userId === userIdSession) {
        return;
      }

      fetch('../../php/page_admin/utils/bannir_utilisateur.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: userId })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          roleCell.textContent = data.nouveau_role;
        } else {
          alert("Erreur : " + data.message);
        }
      })
      .catch(() => alert("Erreur lors de la requête au serveur."));
    });
  });

  // --- Changer rôle ---
  document.querySelectorAll('.btn-changer-role').forEach(button => {
    button.addEventListener('click', () => {
      const row = button.closest('tr');
      const userId = row.dataset.userId;
      const roleCell = row.querySelector('.role');

      if (userId === userIdSession) {
        return;
      }

      fetch('../../php/page_admin/utils/changer_role.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: userId })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          roleCell.textContent = data.nouveau_role;
        } else {
          alert("Erreur : " + data.message);
        }
      })
      .catch(() => alert("Erreur lors de la requête au serveur."));
    });
  });
});
