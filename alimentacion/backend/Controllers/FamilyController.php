<?php
// controllers/FamilyController.php
require_once __DIR__ . '/../services/FamilyService.php';

class FamilyController {
    private $familyService;

    public function __construct() {
        $this->familyService = new FamilyService();
    }

    public function updateCount($data) {
        try {
            if (!isset($data['cantidad'])) {
                return ['status' => 'error', 'message' => 'Faltan datos requeridos.'];
            }

            // Simulamos usuario ID 1 por ahora
            $userId = isset($data['usuario_id']) ? $data['usuario_id'] : 1; 
            
            $this->familyService->setFamilyCount($userId, (int)$data['cantidad']);
            return ['status' => 'success', 'message' => 'Cantidad actualizada correctamente.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
