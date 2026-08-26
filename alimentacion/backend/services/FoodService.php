<?php
// services/FoodService.php
require_once __DIR__ . '/../repositories/FoodRepository.php';

class FoodService {
    private $foodRepository;

    public function __construct() {
        $this->foodRepository = new FoodRepository();
    }

    public function registerFood($data) {
        if (empty(trim($data['nombre'])) || empty(trim($data['categoria']))) {
            throw new Exception("El nombre y categoría son obligatorios.");
        }

        // 1. Obtener ubicación
        $idUbicacion = $this->foodRepository->getDefaultLocation();
        
        // 2. Crear producto
        $idProducto = $this->foodRepository->createProduct($data['nombre'], $data['marca'], $data['categoria']);
        
        // 3. Agregar al inventario
        $cantidad = (float)$data['cantidad'];
        $ingreso = empty($data['fechaIngreso']) ? date('Y-m-d') : $data['fechaIngreso'];
        $venc = $data['fechaVencimiento'];

        return $this->foodRepository->addToInventory($idProducto, $idUbicacion, $cantidad, $ingreso, $venc);
    }
}
