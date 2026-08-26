<?php
// services/FamiliarService.php
require_once __DIR__ . '/../repositories/FamiliarRepository.php';

class FamiliarService {
    private $familiarRepository;

    public function __construct() {
        $this->familiarRepository = new FamiliarRepository();
    }

    public function addMember($userId, $nombre, $tipoAlimentacion) {
        if (empty(trim($nombre))) {
            throw new Exception("El nombre no puede estar vacío.");
        }
        return $this->familiarRepository->create($userId, $nombre, $tipoAlimentacion);
    }

    public function updateHealthData($id, $userId, $alergias, $intolerancias) {
        if ($id <= 0) {
            throw new Exception("ID de familiar inválido.");
        }
        return $this->familiarRepository->updateAllergies($id, $userId, $alergias, $intolerancias);
    }
}
