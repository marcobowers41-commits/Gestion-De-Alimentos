<?php
// controllers/FoodController.php
require_once __DIR__ . '/../services/FoodService.php';

class FoodController {
    private $foodService;

    public function __construct() {
        $this->foodService = new FoodService();
    }

    public function register($data) {
        try {
            $nombre = isset($data['nombre']) ? $data['nombre'] : '';
            $categoria = isset($data['categoria']) ? $data['categoria'] : '';
            $marca = isset($data['marca']) ? $data['marca'] : '';
            $cantidad = isset($data['cantidad']) ? $data['cantidad'] : 0;
            $fechaIngreso = isset($data['fechaIngreso']) ? $data['fechaIngreso'] : '';
            $fechaVencimiento = isset($data['fechaVencimiento']) ? $data['fechaVencimiento'] : '';

            $this->foodService->registerFood([
                'nombre' => $nombre,
                'categoria' => $categoria,
                'marca' => $marca,
                'cantidad' => $cantidad,
                'fechaIngreso' => $fechaIngreso,
                'fechaVencimiento' => $fechaVencimiento
            ]);

            return ['status' => 'success', 'message' => 'Alimento guardado correctamente.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
