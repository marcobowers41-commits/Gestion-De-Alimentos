<?php
// api/member.php
header('Content-Type: application/json');
require_once __DIR__ . '/../controllers/FamiliarController.php';

$controller = new FamiliarController();
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    
    if ($action === 'create') {
        echo json_encode($controller->create($data));
    } elseif ($action === 'health') {
        echo json_encode($controller->updateHealth($data));
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
