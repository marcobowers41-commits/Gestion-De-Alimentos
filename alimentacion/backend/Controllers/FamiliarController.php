<?php
// controllers/FamiliarController.php
require_once __DIR__ . '/../services/FamiliarService.php';

class FamiliarController {
    private $familiarService;

    public function __construct() {
        $this->familiarService = new FamiliarService();
    }

    public function create($data) {
        try {
            $userId = isset($data['usuario_id']) ? $data['usuario_id'] : 1; 
            $nombre = isset($data['nombre']) ? $data['nombre'] : '';
            $tipoAlimentacion = isset($data['tipoAlimentacion']) ? $data['tipoAlimentacion'] : [];

            $familiarId = $this->familiarService->addMember($userId, $nombre, $tipoAlimentacion);
            return ['status' => 'success', 'familiar_id' => $familiarId];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateHealth($data) {
        try {
            $userId = isset($data['usuario_id']) ? $data['usuario_id'] : 1; 
            $familiarId = isset($data['familiar_id']) ? (int)$data['familiar_id'] : 0;
            $alergias = isset($data['alergias']) ? $data['alergias'] : '';
            $intolerancias = isset($data['intolerancias']) ? $data['intolerancias'] : [];

            $this->familiarService->updateHealthData($familiarId, $userId, $alergias, $intolerancias);
            return ['status' => 'success', 'message' => 'Datos de salud guardados.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
