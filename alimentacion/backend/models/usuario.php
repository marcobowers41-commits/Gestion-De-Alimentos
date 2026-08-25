<?php

class User
{
    public ?int $id;
    public string $usuario;
    public string $email;
    public string $passwordHash;

    public function __construct(
        string $usuario,
        string $email,
        string $passwordHash,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }
}
?>
