<?php
// backend/services/LikesService.php

require_once __DIR__ . '/../repositories/LikesRepository.php';

class LikesService
{
    private LikesRepository $likesRepository;

    public function __construct(LikesRepository $likesRepository)
    {
        $this->likesRepository = $likesRepository;
    }

    public function saveDislikes(array $alimentos): array
    {
        foreach ($alimentos as $alimento) {
            $nombre = trim($alimento);
            if (!empty($nombre)) {
                $this->likesRepository->saveDislike($nombre);
            }
        }

        return [
            'status'  => 'success',
            'message' => 'Preferencias de alimentos guardadas.'
        ];
    }
}
?>
