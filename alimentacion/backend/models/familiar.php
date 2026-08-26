<?php
// backend/models/familiar.php

class Familiar
{
    public ?int $id;
    public int $usuarioId;
    public string $nombre;
    public string $tipoAlimentacion;
    public string $alergias;
    public string $intolerancias;

    public function __construct(
        int $usuarioId,
        string $nombre,
        string $tipoAlimentacion = '[]',
        string $alergias = '[]',
        string $intolerancias = '[]',
        ?int $id = null
    ) {
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->nombre = $nombre;
        $this->tipoAlimentacion = $tipoAlimentacion;
        $this->alergias = $alergias;
        $this->intolerancias = $intolerancias;
    }
}
?>
