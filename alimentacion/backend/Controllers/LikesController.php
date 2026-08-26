<?php
// backend/Controllers/LikesController.php

require_once __DIR__ . '/../services/LikesService.php';

class LikesController
{
    private LikesService $likesService;

    public function __construct(LikesService $likesService)
    {
        $this->likesService = $likesService;
    }

    public function saveDislikes(array $alimentos): array
    {
        return $this->likesService->saveDislikes($alimentos);
    }
}
?>
