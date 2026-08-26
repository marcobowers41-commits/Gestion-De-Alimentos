<?php
// backend/models/inventario.php

class Inventario
{
    public ?int $idInventario;
    public int $idProducto;
    public int $idUbicacion;
    public float $cantidad;
    public string $unidadMedida;
    public string $fechaIngreso;
    public ?string $fechaVencimiento;

    public function __construct(
        int $idProducto,
        int $idUbicacion,
        float $cantidad,
        string $unidadMedida = 'unidades',
        string $fechaIngreso = '',
        ?string $fechaVencimiento = null,
        ?int $idInventario = null
    ) {
        $this->idInventario = $idInventario;
        $this->idProducto = $idProducto;
        $this->idUbicacion = $idUbicacion;
        $this->cantidad = $cantidad;
        $this->unidadMedida = $unidadMedida;
        $this->fechaIngreso = $fechaIngreso ?: date('Y-m-d H:i:s');
        $this->fechaVencimiento = $fechaVencimiento;
    }
}
?>
