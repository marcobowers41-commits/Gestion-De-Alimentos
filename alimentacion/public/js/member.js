// public/js/member.js
// Pantalla 5 - Integrante

document.getElementById('btn-siguiente')?.addEventListener('click', async function(e) {
    e.preventDefault();

    const nombre = document.getElementById('mem-nombre')?.value;
    const pills = document.querySelectorAll('#mem-diets .pill.selected');
    const tipoAlimentacion = Array.from(pills).map(p => p.textContent.trim());
    const usuarioId = localStorage.getItem('usuario_id') || 1;

    if (!nombre || nombre.trim() === '') {
        alert('Ingresá el nombre del integrante.');
        return;
    }

    try {
        const res = await fetch('../backend/api/member.php?action=create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                usuario_id: parseInt(usuarioId),
                nombre,
                tipoAlimentacion
            })
        });

        const data = await res.json();

        if (data.status === 'success') {
            localStorage.setItem('familiar_id', data.familiar_id);
            window.location.href = 'allergies.html';
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Error de conexión con el servidor.');
    }
});
