<?php
// backend/api/login.php

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

// Leer tanto $_POST como JSON
$input = json_decode(file_get_contents('php://input'), true);
$email = trim($_POST['email'] ?? $input['email'] ?? $input['usuario'] ?? '');
$password = $_POST['password'] ?? $input['password'] ?? '';

$response = $authController->login($email, $password);

// Si fue exitoso, devolver también el id de sesión
if ($response['status'] === 'success' && isset($_SESSION['usuarioId'])) {
    $response['usuario_id'] = $_SESSION['usuarioId'];
    $response['usuario'] = $_SESSION['usuarioNombre'];
}

echo json_encode($response);
?>