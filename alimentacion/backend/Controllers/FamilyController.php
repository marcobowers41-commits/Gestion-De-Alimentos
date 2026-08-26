<?php
// backend/Controllers/FamilyController.php

require_once __DIR__ . '/../services/FamilyService.php';

class FamilyController
{
    private FamilyService $familyService;

    public function __construct(FamilyService $familyService)
    {
        $this->familyService = $familyService;
    }

    public function updateCount(int $userId, int $cantidad): array
    {
        return $this->familyService->setFamilyCount($userId, $cantidad);
    }
}
?>
