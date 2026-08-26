<?php
// backend/api/member.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Controllers/FamiliarController.php';
require_once __DIR__ . '/../services/FamiliarService.php';
require_once __DIR__ . '/../repositories/FamiliarRepository.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$familiarRepository = new FamiliarRepository($conn);
$familiarService = new FamiliarService($familiarRepository);
$familiarController = new FamiliarController($familiarService);

$action = $_GET['action'] ?? 'create';
$input = json_decode(file_get_contents('php://input'), true);

$userId = (int)($_SESSION['usuarioId'] ?? $_POST['usuario_id'] ?? $input['usuario_id'] ?? 1);

if ($action === 'create') {
    $nombre = trim($_POST['nombre'] ?? $input['nombre'] ?? '');
    $tipoAlimentacion = $_POST['tipoAlimentacion'] ?? $input['tipoAlimentacion'] ?? [];
    if (is_string($tipoAlimentacion)) {
        $tipoAlimentacion = json_decode($tipoAlimentacion, true) ?: [$tipoAlimentacion];
    }

    $response = $familiarController->create($userId, $nombre, $tipoAlimentacion);
} elseif ($action === 'health') {
    $familiarId = (int)($_POST['familiar_id'] ?? $input['familiar_id'] ?? 0);
    $alergias = trim($_POST['alergias'] ?? $input['alergias'] ?? '');
    $intolerancias = $_POST['intolerancias'] ?? $input['intolerancias'] ?? [];
    if (is_string($intolerancias)) {
        $intolerancias = json_decode($intolerancias, true) ?: [$intolerancias];
    }

    $response = $familiarController->updateHealth($familiarId, $userId, $alergias, $intolerancias);
} else {
    $response = ['status' => 'error', 'message' => 'Acción no válida'];
}

echo json_encode($response);
?>
