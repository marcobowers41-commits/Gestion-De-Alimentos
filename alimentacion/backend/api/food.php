<?php
// backend/api/food.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
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

$input = json_decode(file_get_contents('php://input'), true);

$data = [
    'nombre'           => $_POST['nombre'] ?? $input['nombre'] ?? '',
    'categoria'        => $_POST['categoria'] ?? $input['categoria'] ?? '',
    'marca'            => $_POST['marca'] ?? $input['marca'] ?? '',
    'cantidad'         => $_POST['cantidad'] ?? $input['cantidad'] ?? 1,
    'fechaIngreso'     => $_POST['fechaIngreso'] ?? $input['fechaIngreso'] ?? '',
    'fechaVencimiento' => $_POST['fechaVencimiento'] ?? $input['fechaVencimiento'] ?? ''
];

$response = $foodController->register($data);

echo json_encode($response);
?>
