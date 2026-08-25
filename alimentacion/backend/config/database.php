<?php
// Configuración de credenciales
$host = 'localhost';
$db   = 'usuario';
$user = 'root';
$pass = '';
$port = '3306';
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];


try {
    // Intentar conectar
    $conn = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    // Capturar y mostrar el error si falla la conexión
    echo " Error al conectar: " . htmlspecialchars($e->getMessage());
}
?>