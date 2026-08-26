<?php
// backend/services/FamilyService.php

require_once __DIR__ . '/../repositories/UserRepository.php';

class FamilyService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function setFamilyCount(int $userId, int $count): array
    {
        if ($count < 1) {
            return [
                'status'  => 'error',
                'message' => 'La cantidad de familiares debe ser al menos 1.'
            ];
        }

        $actualizado = $this->userRepository->updateFamilyCount($userId, $count);

        if (!$actualizado) {
            return [
                'status'  => 'error',
                'message' => 'No se pudo actualizar la cantidad de familiares.'
            ];
        }

        return [
            'status'  => 'success',
            'message' => 'Cantidad de familiares actualizada correctamente.'
        ];
    }
}
?>
