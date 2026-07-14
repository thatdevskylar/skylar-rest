// Copy-to-clipboard for the email button, with a small inline confirmation.
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-copy]').forEach((el) => {
    el.addEventListener('click', (e) => {
      const value = el.getAttribute('data-copy');
      if (!value || !navigator.clipboard) return;
      e.preventDefault();
      navigator.clipboard.writeText(value).then(() => {
        const original = el.textContent;
        el.textContent = 'copied ✓';
        setTimeout(() => { el.textContent = original; }, 1600);
      });
    });
  });
});
