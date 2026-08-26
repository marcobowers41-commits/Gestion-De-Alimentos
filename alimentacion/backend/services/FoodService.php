<?php
// backend/services/FoodService.php

require_once __DIR__ . '/../repositories/FoodRepository.php';

class FoodService
{
    private FoodRepository $foodRepository;

    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    public function registerFood(array $data): array
    {
        $nombre = trim($data['nombre'] ?? '');
        $categoria = trim($data['categoria'] ?? '');
        $marca = trim($data['marca'] ?? '');
        $cantidad = (float)($data['cantidad'] ?? 1);
        $fechaIngreso = trim($data['fechaIngreso'] ?? '');
        $fechaVencimiento = trim($data['fechaVencimiento'] ?? '');

        if (empty($nombre)) {
            return [
                'status'  => 'error',
                'message' => 'El nombre del alimento es obligatorio.'
            ];
        }

        if (empty($categoria)) {
            return [
                'status'  => 'error',
                'message' => 'La categoría es obligatoria.'
            ];
        }

        // Obtener ubicación adecuada según la categoría o default
        $ubicacionTipo = 'heladera';
        $categoriaLower = strtolower($categoria);
        if (str_contains($categoriaLower, 'seco') || str_contains($categoriaLower, 'galletita') || str_contains($categoriaLower, 'aceite')) {
            $ubicacionTipo = 'despensa';
        } elseif (str_contains($categoriaLower, 'congelado') || str_contains($categoriaLower, 'carne')) {
            $ubicacionTipo = 'freezer';
        }

        $idUbicacion = $this->foodRepository->getDefaultLocation($ubicacionTipo);

        // Crear producto
        $idProducto = $this->foodRepository->createProduct($nombre, $marca ?: null, $categoria);

        if ($idProducto === false) {
            return [
                'status'  => 'error',
                'message' => 'No se pudo registrar el producto.'
            ];
        }

        // Agregar al inventario
        $ingreso = empty($fechaIngreso) ? date('Y-m-d H:i:s') : $fechaIngreso;
        $venc = empty($fechaVencimiento) ? null : $fechaVencimiento;

        $agregado = $this->foodRepository->addToInventory(
            $idProducto,
            $idUbicacion,
            $cantidad,
            'unidades',
            $ingreso,
            $venc
        );

        if (!$agregado) {
            return [
                'status'  => 'error',
                'message' => 'No se pudo agregar el alimento al inventario.'
            ];
        }

        return [
            'status'  => 'success',
            'message' => 'Alimento registrado correctamente en el inventario.'
        ];
    }

    public function getStock(string $tipoUbicacion): array
    {
        $items = $this->foodRepository->getInventoryByLocationType($tipoUbicacion);
        return [
            'status' => 'success',
            'data'   => $items
        ];
    }
}
?>
