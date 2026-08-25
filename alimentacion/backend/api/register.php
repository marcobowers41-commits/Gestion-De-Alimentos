<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");



require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

$userRepository = new UserRepository($conn);
$authService = new AuthService($userRepository);
$authController = new AuthController($authService);

$usuario = trim($_POST['usuario'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$cantidadFamiliares = $_POST['cantidadFamiliares'];

$response = $authController->register(
    $usuario,
    $email,
    $password,
    $cantidadFamiliares
);

echo json_encode($response);

?>