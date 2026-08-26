<?php
// api/family.php
header('Content-Type: application/json');
require_once __DIR__ . '/../controllers/FamilyController.php';

$controller = new FamilyController();
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode($controller->updateCount($data));
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
