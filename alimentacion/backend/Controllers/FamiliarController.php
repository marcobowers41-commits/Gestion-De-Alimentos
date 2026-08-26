<?php
// backend/Controllers/FamiliarController.php

require_once __DIR__ . '/../services/FamiliarService.php';

class FamiliarController
{
    private FamiliarService $familiarService;

    public function __construct(FamiliarService $familiarService)
    {
        $this->familiarService = $familiarService;
    }

    public function create(int $userId, string $nombre, array $tipoAlimentacion): array
    {
        return $this->familiarService->addMember($userId, $nombre, $tipoAlimentacion);
    }

    public function updateHealth(int $familiarId, int $userId, string $alergias, array $intolerancias): array
    {
        return $this->familiarService->updateHealthData($familiarId, $userId, $alergias, $intolerancias);
    }
}
?>
