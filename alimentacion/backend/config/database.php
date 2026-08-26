<?php
// backend/config/database.php

$host = 'localhost';
$db   = 'gestion_alimentaria';
$user = 'root';
$pass = '';
$port = '3306';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Si falla gestion_alimentaria, intentar conectar a usuario por compatibilidad
    try {
        $dsnFallback = "mysql:host=$host;port=$port;dbname=usuario;charset=$charset";
        $conn = new PDO($dsnFallback, $user, $pass, $options);
    } catch (PDOException $e2) {
        die(json_encode(['status' => 'error', 'message' => 'Error al conectar a la base de datos: ' . $e->getMessage()]));
    }
}
?>