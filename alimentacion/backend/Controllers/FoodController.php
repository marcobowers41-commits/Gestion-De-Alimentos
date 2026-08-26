<?php
// backend/Controllers/FoodController.php

require_once __DIR__ . '/../services/FoodService.php';

class FoodController
{
    private FoodService $foodService;

    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    public function register(array $data): array
    {
        return $this->foodService->registerFood($data);
    }

    public function getStock(string $tipoUbicacion): array
    {
        return $this->foodService->getStock($tipoUbicacion);
    }
}
?>
