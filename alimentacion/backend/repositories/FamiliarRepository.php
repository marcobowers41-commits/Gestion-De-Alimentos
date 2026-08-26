<?php
// backend/repositories/FamiliarRepository.php

class FamiliarRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(int $usuarioId, string $nombre, array $tipoAlimentacion): int|false
    {
        $sql = "
            INSERT INTO familiares (usuario_id, nombre, tipo_alimentacion, alergias, intolerancias)
            VALUES (:usuario_id, :nombre, :tipo_alimentacion, '[]', '[]')
        ";

        $sentencia = $this->conn->prepare($sql);
        $ejecutado = $sentencia->execute([
            ':usuario_id'         => $usuarioId,
            ':nombre'             => $nombre,
            ':tipo_alimentacion'  => json_encode($tipoAlimentacion)
        ]);

        if (!$ejecutado) {
            return false;
        }

        return (int)$this->conn->lastInsertId();
    }

    public function updateHealth(int $id, int $usuarioId, string $alergias, array $intolerancias): bool
    {
        $sql = "
            UPDATE familiares
            SET alergias = :alergias, intolerancias = :intolerancias
            WHERE id = :id AND usuario_id = :usuario_id
        ";

        $sentencia = $this->conn->prepare($sql);
        return $sentencia->execute([
            ':alergias'       => json_encode([$alergias]),
            ':intolerancias'  => json_encode($intolerancias),
            ':id'             => $id,
            ':usuario_id'     => $usuarioId
        ]);
    }

    public function getByUserId(int $usuarioId): array
    {
        $sql = "SELECT * FROM familiares WHERE usuario_id = :usuario_id";
        $sentencia = $this->conn->prepare($sql);
        $sentencia->execute([':usuario_id' => $usuarioId]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
