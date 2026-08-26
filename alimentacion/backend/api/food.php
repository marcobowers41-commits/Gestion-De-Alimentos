<?php
// api/food.php
header('Content-Type: application/json');
require_once __DIR__ . '/../controllers/FoodController.php';

$controller = new FoodController();
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode($controller->register($data));
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
