// public/js/food.js
// Pantalla 8 - Gestión de Alimentos

document.getElementById('btn-siguiente')?.addEventListener('click', async function(e) {
    e.preventDefault();

    const nombre = document.getElementById('f-nombre')?.value;
    const categoria = document.getElementById('f-categoria')?.value;
    const marca = document.getElementById('f-marca')?.value;
    const cantidad = document.getElementById('f-cantidad')?.value;
    const fechaIngreso = document.getElementById('f-ingreso')?.value;
    const fechaVencimiento = document.getElementById('f-vencimiento')?.value;

    if (!nombre || nombre.trim() === '') {
        alert('El nombre del alimento es obligatorio.');
        return;
    }
    if (!categoria || categoria.trim() === '') {
        alert('La categoría es obligatoria.');
        return;
    }

    try {
        const res = await fetch('../backend/api/food.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nombre,
                categoria,
                marca,
                cantidad: cantidad ? parseFloat(cantidad) : 1,
                fechaIngreso,
                fechaVencimiento
            })
        });

        const data = await res.json();

        if (data.status === 'success') {
            alert('¡Alimento guardado correctamente en el inventario!');
            window.location.href = 'space.html';
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Error de conexión con el servidor.');
    }
});
