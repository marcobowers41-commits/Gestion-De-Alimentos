<?php
// repositories/UserRepository.php
require_once __DIR__ . '/../config/database.php';

class UserRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function updateFamilyCount($userId, $count) {
        $sql = "UPDATE usuarios SET cantidad_familiares = :count WHERE id = :userId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':count' => $count, ':userId' => $userId]);
    }
}
