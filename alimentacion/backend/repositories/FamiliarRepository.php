<?php
// repositories/FamiliarRepository.php
require_once __DIR__ . '/../config/database.php';

class FamiliarRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create($userId, $nombre, $tipoAlimentacion) {
        $sql = "INSERT INTO familiares (usuario_id, nombre, tipo_alimentacion, alergias, intolerancias) VALUES (:userId, :nombre, :tipo, '[]', '[]')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':userId' => $userId,
            ':nombre' => $nombre,
            ':tipo' => json_encode($tipoAlimentacion)
        ]);
        return $this->db->lastInsertId();
    }

    public function updateAllergies($id, $userId, $alergias, $intolerancias) {
        $sql = "UPDATE familiares SET alergias = :alergias, intolerancias = :intolerancias WHERE id = :id AND usuario_id = :userId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':alergias' => json_encode([$alergias]),
            ':intolerancias' => json_encode($intolerancias),
            ':id' => $id,
            ':userId' => $userId
        ]);
    }
}
