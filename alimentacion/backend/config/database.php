<?php
// backend/config/database.php
// Configuración exclusiva para InfinityFree

$host = 'sql302.byetcluster.com';
$db   = 'if0_42586714_ll';
$user = 'if0_42586714';
$pass = 'Tecnica2junin';
$port = '3306';
$charset = 'utf8mb4';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en caso de error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve arrays asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa sentencias preparadas reales
];

try {
    // Conectar a la base de datos de InfinityFree
    $conn = new PDO($dsn, $user, $pass, $options);
    $pdo = $conn;
} catch (PDOException $e) {
    header('Content-Type: application/json');
    die(json_encode([
        'status'  => 'error',
        'message' => 'Error al conectar con la base de datos de InfinityFree: ' . $e->getMessage()
    ]));
}
?>