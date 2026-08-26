<?php
// backend/models/producto.php

class Producto
{
    public ?int $idProducto;
    public string $nombre;
    public ?string $marca;
    public ?string $categoria;

    public function __construct(
        string $nombre,
        ?string $marca = null,
        ?string $categoria = null,
        ?int $idProducto = null
    ) {
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->marca = $marca;
        $this->categoria = $categoria;
    }
}
?>
