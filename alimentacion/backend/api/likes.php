<?php
// backend/api/likes.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Controllers/LikesController.php';
require_once __DIR__ . '/../services/LikesService.php';
require_once __DIR__ . '/../repositories/LikesRepository.php';

$likesRepository = new LikesRepository($conn);
$likesService = new LikesService($likesRepository);
$likesController = new LikesController($likesService);

$input = json_decode(file_get_contents('php://input'), true);

$dislikes = $_POST['dislikes'] ?? $input['dislikes'] ?? [];
if (is_string($dislikes)) {
    $dislikes = json_decode($dislikes, true) ?: [$dislikes];
}

$response = $likesController->saveDislikes($dislikes);

echo json_encode($response);
?>
