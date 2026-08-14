// Authentication-specific JavaScript can be extended in later parts.
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('button[type="submit"]');
        if (button) button.disabled = true;
    });
});