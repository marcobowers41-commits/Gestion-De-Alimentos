<?php
// backend/repositories/FoodRepository.php

class FoodRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getDefaultLocation(string $tipo = 'heladera'): int
    {
        $sql = "SELECT id_ubicacion FROM ubicaciones WHERE tipo = :tipo LIMIT 1";
        $sentencia = $this->conn->prepare($sql);
        $sentencia->execute([':tipo' => $tipo]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return (int)$fila['id_ubicacion'];
        }

        // Si no existe, crear ubicación por defecto
        $sqlInsert = "INSERT INTO ubicaciones (tipo, nombre) VALUES (:tipo, :nombre)";
        $sentenciaInsert = $this->conn->prepare($sqlInsert);
        $sentenciaInsert->execute([
            ':tipo'   => $tipo,
            ':nombre' => ucfirst($tipo)
        ]);

        return (int)$this->conn->lastInsertId();
    }

    public function createProduct(string $nombre, ?string $marca, ?string $categoria): int|false
    {
        $sql = "INSERT INTO productos (nombre, marca, categoria) VALUES (:nombre, :marca, :categoria)";
        $sentencia = $this->conn->prepare($sql);
        $ejecutado = $sentencia->execute([
            ':nombre'    => $nombre,
            ':marca'     => $marca,
            ':categoria' => $categoria
        ]);

        if (!$ejecutado) {
            return false;
        }

        return (int)$this->conn->lastInsertId();
    }

    public function addToInventory(
        int $idProducto,
        int $idUbicacion,
        float $cantidad,
        string $unidadMedida,
        string $fechaIngreso,
        ?string $fechaVencimiento
    ): bool {
        $sql = "
            INSERT INTO inventario (id_producto, id_ubicacion, cantidad, unidad_medida, fecha_ingreso, fecha_vencimiento)
            VALUES (:id_producto, :id_ubicacion, :cantidad, :unidad_medida, :fecha_ingreso, :fecha_vencimiento)
        ";

        $sentencia = $this->conn->prepare($sql);
        return $sentencia->execute([
            ':id_producto'       => $idProducto,
            ':id_ubicacion'      => $idUbicacion,
            ':cantidad'          => $cantidad,
            ':unidad_medida'     => $unidadMedida,
            ':fecha_ingreso'     => $fechaIngreso,
            ':fecha_vencimiento' => $fechaVencimiento
        ]);
    }

    public function getInventoryByLocationType(string $tipo): array
    {
        $sql = "
            SELECT i.id_inventario, p.nombre, p.marca, p.categoria, i.cantidad, i.unidad_medida, i.fecha_ingreso, i.fecha_vencimiento, u.nombre as ubicacion
            FROM inventario i
            JOIN productos p ON i.id_producto = p.id_producto
            JOIN ubicaciones u ON i.id_ubicacion = u.id_ubicacion
            WHERE u.tipo = :tipo
            ORDER BY i.fecha_ingreso DESC
        ";

        $sentencia = $this->conn->prepare($sql);
        $sentencia->execute([':tipo' => $tipo]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
