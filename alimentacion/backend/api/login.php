<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

$userRepository = new UserRepository($conn);
$authService = new AuthService($userRepository);
$authController = new AuthController($authService);


$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';


$response = $authController->login(
    $email,
    $password
);

echo json_encode($response);

?>