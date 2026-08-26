<?php
// backend/api/inventory.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Controllers/FoodController.php';
require_once __DIR__ . '/../services/FoodService.php';
require_once __DIR__ . '/../repositories/FoodRepository.php';

$foodRepository = new FoodRepository($conn);
$foodService = new FoodService($foodRepository);
$foodController = new FoodController($foodService);

$tipo = $_GET['tipo'] ?? 'heladera';

$response = $foodController->getStock($tipo);

echo json_encode($response);
?>
