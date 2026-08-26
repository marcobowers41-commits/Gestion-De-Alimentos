<?php
// backend/api/register.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Controllers/AuthController.php';
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

$userRepository = new UserRepository($conn);
$authService = new AuthService($userRepository);
$authController = new AuthController($authService);

$input = json_decode(file_get_contents('php://input'), true);
$usuario = trim($_POST['usuario'] ?? $input['usuario'] ?? '');
$email = trim($_POST['email'] ?? $input['email'] ?? '');
$password = $_POST['password'] ?? $input['password'] ?? '';
$cantidadFamiliares = (int)($_POST['cantidadFamiliares'] ?? $input['cantidadFamiliares'] ?? 1);

$response = $authController->register(
    $usuario,
    $email,
    $password,
    $cantidadFamiliares
);

echo json_encode($response);
?>