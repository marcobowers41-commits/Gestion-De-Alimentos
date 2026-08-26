<?php
// backend/api/family.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Controllers/FamilyController.php';
require_once __DIR__ . '/../services/FamilyService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userRepository = new UserRepository($conn);
$familyService = new FamilyService($userRepository);
$familyController = new FamilyController($familyService);

$input = json_decode(file_get_contents('php://input'), true);

$userId = (int)($_SESSION['usuarioId'] ?? $_POST['usuario_id'] ?? $input['usuario_id'] ?? 1);
$cantidad = (int)($_POST['cantidad'] ?? $input['cantidad'] ?? 1);

$response = $familyController->updateCount($userId, $cantidad);

echo json_encode($response);
?>
