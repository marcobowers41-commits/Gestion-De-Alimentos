<?php
// repositories/FoodRepository.php
require_once __DIR__ . '/../config/database.php';

class FoodRepository {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getDefaultLocation() {
        $stmt = $this->db->query("SELECT id_ubicacion FROM ubicaciones LIMIT 1");
        $ubic = $stmt->fetch();
        if ($ubic) {
            return $ubic['id_ubicacion'];
        }
        
        $this->db->query("INSERT INTO ubicaciones (tipo, nombre) VALUES ('otro', 'General')");
        return $this->db->lastInsertId();
    }

    public function createProduct($nombre, $marca, $categoria) {
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, marca, categoria) VALUES (:nombre, :marca, :categoria)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':marca' => $marca,
            ':categoria' => $categoria
        ]);
        return $this->db->lastInsertId();
    }

    public function addToInventory($idProducto, $idUbicacion, $cantidad, $fechaIngreso, $fechaVencimiento) {
        $stmt = $this->db->prepare("INSERT INTO inventario (id_producto, id_ubicacion, cantidad, unidad_medida, fecha_ingreso, fecha_vencimiento) VALUES (:idProducto, :idUbicacion, :cantidad, 'unidades', :ingreso, :vencimiento)");
        return $stmt->execute([
            ':idProducto' => $idProducto,
            ':idUbicacion' => $idUbicacion,
            ':cantidad' => $cantidad,
            ':ingreso' => $fechaIngreso,
            ':vencimiento' => empty($fechaVencimiento) ? null : $fechaVencimiento
        ]);
    }
}
