<?php

class LoginUpService{

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

    function cerrarSesion(){

    if (session_status() !== PHP_SESSION_ACTIVE) {
        return;
    }

    // Vaciar los datos de la sesión
    $_SESSION = [];

    // Eliminar la cookie de sesión
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Destruir la sesión
    session_destroy();
}
}
?>
