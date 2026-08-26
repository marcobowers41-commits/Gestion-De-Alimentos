// public/js/likes.js
// Pantalla 7 - Alimentos que no gustan

document.getElementById('btn-siguiente')?.addEventListener('click', async function(e) {
    e.preventDefault();

    const selectedButtons = document.querySelectorAll('.likes-list .like-row.selected b');
    const dislikes = Array.from(selectedButtons).map(b => b.textContent.trim());

    if (dislikes.length > 0) {
        try {
            await fetch('../backend/api/likes.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ dislikes })
            });
        } catch (error) {
            console.error('Error al guardar preferencias:', error);
        }
    }

    // Avanzar a la pantalla de alimentos
    window.location.href = 'food.html';
});
