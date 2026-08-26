// public/js/allergies.js
// Pantalla 6 - Alergias e Intolerancias

document.getElementById('btn-siguiente')?.addEventListener('click', async function(e) {
    e.preventDefault();

    const alergias = document.getElementById('al-alergias')?.value || '';
    const pills = document.querySelectorAll('#al-intolerances .pill.selected');
    const intolerancias = Array.from(pills).map(p => p.textContent.trim());
    const familiarId = localStorage.getItem('familiar_id') || 1;
    const usuarioId = localStorage.getItem('usuario_id') || 1;

    try {
        const res = await fetch('../backend/api/member.php?action=health', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                usuario_id: parseInt(usuarioId),
                familiar_id: parseInt(familiarId),
                alergias,
                intolerancias
            })
        });

        const data = await res.json();

        if (data.status === 'success') {
            window.location.href = 'likes.html';
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Error de conexión con el servidor.');
    }
});
