// public/js/family.js
// Pantalla 4 - Familia

document.getElementById('btn-siguiente')?.addEventListener('click', async function(e) {
    e.preventDefault();

    const cantidad = document.getElementById('fam-cantidad')?.value || 1;
    const pills = document.querySelectorAll('#fam-diets .pill.selected');
    const tipoAlimentacion = Array.from(pills).map(p => p.textContent.trim());
    const usuarioId = localStorage.getItem('usuario_id') || 1;

    if (!cantidad || cantidad < 1) {
        alert('Ingresá una cantidad válida de familiares.');
        return;
    }

    try {
        const res = await fetch('../backend/api/family.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                usuario_id: parseInt(usuarioId),
                cantidad: parseInt(cantidad),
                tipoAlimentacion
            })
        });

        const data = await res.json();

        if (data.status === 'success') {
            window.location.href = 'member.html';
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Error de conexión con el servidor.');
    }
});
