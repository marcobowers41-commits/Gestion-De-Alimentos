<?php
require_once 'conexion.php'; 

function iniciarSesion($id, $nombre){
    // 1. Asegurar que el sistema de sesiones esté activo
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. Prevenir fijación de sesión creando un ID interno nuevo y seguro
    session_regenerate_id(true);

    // 3. Guardar los datos en el arreglo global $_SESSION
    $_SESSION['usuarioId'] = $id;
    $_SESSION['usuarioNombre'] = $nombre;
    $_SESSION['autenticado'] = true;
}
?>
