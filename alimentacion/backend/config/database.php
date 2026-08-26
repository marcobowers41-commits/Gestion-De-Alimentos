<?php
// config/database.php
class Database {
    private static $host = 'sql302.byetcluster.com';
    private static $db   = 'if0_42586714_ll';
    private static $user = 'if0_42586714';
    private static $pass = 'Tecnica2junin';
    private static $port = '3306';
    private static $charset = 'utf8mb4';
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db . ";charset=" . self::$charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                // Si falla local, se puede cambiar a localhost en entorno local
                self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                die(json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $e->getMessage()]));
            }
        }
        return self::$pdo;
    }
}
