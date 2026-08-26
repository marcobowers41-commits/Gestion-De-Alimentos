<?php
// services/FamilyService.php
require_once __DIR__ . '/../repositories/UserRepository.php';

class FamilyService {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function setFamilyCount($userId, $count) {
        if ($count < 1) {
            throw new Exception("La cantidad de familiares debe ser mayor a 0.");
        }
        return $this->userRepository->updateFamilyCount($userId, $count);
    }
}
