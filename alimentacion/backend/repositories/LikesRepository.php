<?php
// backend/repositories/LikesRepository.php

class LikesRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function saveDislike(string $nombreAlimento): bool
    {
        // Buscar si existe el producto por nombre
        $sqlProd = "SELECT id_producto FROM productos WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->conn->prepare($sqlProd);
        $stmt->execute([':nombre' => $nombreAlimento]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);

        $idProducto = 0;
        if ($prod) {
            $idProducto = (int)$prod['id_producto'];
        } else {
            // Crear producto básico
            $sqlNew = "INSERT INTO productos (nombre) VALUES (:nombre)";
            $stmtNew = $this->conn->prepare($sqlNew);
            $stmtNew->execute([':nombre' => $nombreAlimento]);
            $idProducto = (int)$this->conn->lastInsertId();
        }

        // Insertar en productos_que_no_gustan ignorando duplicados
        $sqlDislike = "INSERT IGNORE INTO productos_que_no_gustan (Id_producto) VALUES (:id_producto)";
        $stmtDislike = $this->conn->prepare($sqlDislike);
        return $stmtDislike->execute([':id_producto' => $idProducto]);
    }
}
?>
