<?php
// backend/services/FamiliarService.php

require_once __DIR__ . '/../repositories/FamiliarRepository.php';

class FamiliarService
{
    private FamiliarRepository $familiarRepository;

    public function __construct(FamiliarRepository $familiarRepository)
    {
        $this->familiarRepository = $familiarRepository;
    }

    public function addMember(int $userId, string $nombre, array $tipoAlimentacion): array
    {
        $nombreLimpio = trim($nombre);

        if (empty($nombreLimpio)) {
            return [
                'status'  => 'error',
                'message' => 'Ingresá el nombre del integrante.'
            ];
        }

        $id = $this->familiarRepository->create($userId, $nombreLimpio, $tipoAlimentacion);

        if ($id === false) {
            return [
                'status'  => 'error',
                'message' => 'No se pudo guardar el integrante familiar.'
            ];
        }

        return [
            'status'      => 'success',
            'message'     => 'Integrante agregado correctamente.',
            'familiar_id' => $id
        ];
    }

    public function updateHealthData(int $familiarId, int $userId, string $alergias, array $intolerancias): array
    {
        if ($familiarId <= 0) {
            return [
                'status'  => 'error',
                'message' => 'ID de integrante no válido.'
            ];
        }

        $actualizado = $this->familiarRepository->updateHealth($familiarId, $userId, trim($alergias), $intolerancias);

        if (!$actualizado) {
            return [
                'status'  => 'error',
                'message' => 'No se pudieron actualizar los datos de salud.'
            ];
        }

        return [
            'status'  => 'success',
            'message' => 'Alergias e intolerancias guardadas correctamente.'
        ];
    }
}
?>
