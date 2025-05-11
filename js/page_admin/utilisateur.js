document.addEventListener('DOMContentLoaded', () => {
  // Bannir / débannir avec icône ❌
  document.querySelectorAll('.btn-bannir').forEach(button => {
    button.addEventListener('click', () => {
      button.disabled = true;
      button.textContent = '...';
      button.style.cursor = 'not-allowed';

      setTimeout(() => {
        const row = button.closest('tr');
        const statutSpan = row.querySelector('.statut');
        if (statutSpan.textContent === 'Banni') {
          statutSpan.textContent = 'Actif';
          button.textContent = '❌';
        } else {
          statutSpan.textContent = 'Banni';
          button.textContent = '❌';
        }
        button.disabled = false;
        button.style.cursor = 'pointer';
      }, 2000);
    });
  });

  // Changer rôle Admin / Client avec icône 🔁
  document.querySelectorAll('.btn-changer-role').forEach(button => {
    button.addEventListener('click', () => {
      button.disabled = true;
      button.textContent = '...';
      button.style.cursor = 'not-allowed';

      setTimeout(() => {
        const row = button.closest('tr');
        const roleSpan = row.querySelector('.role');
        if (roleSpan.textContent === 'admin') {
          roleSpan.textContent = 'client';
        } else {
          roleSpan.textContent = 'admin';
        }
        button.textContent = '🔁';
        button.disabled = false;
        button.style.cursor = 'pointer';
      }, 2000);
    });
  });
});
