<?php

class UserRepository
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function existsByEmail(string $email): bool
    {
        $sql = "
            SELECT id
            FROM usuarios
            WHERE email = :email
            LIMIT 1
        ";

        $sentencia = $this->conn->prepare($sql);

        $sentencia->execute([
            ':email' => $email
        ]);

        return $sentencia->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function existsByUsername(string $usuario): bool
    {
        $sql = "
            SELECT id
            FROM usuarios
            WHERE usuario = :usuario
            LIMIT 1
        ";

        $sentencia = $this->conn->prepare($sql);

        $sentencia->execute([
            ':usuario' => $usuario
        ]);

        return $sentencia->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function create(
        string $usuario,
        string $email,
        string $passwordHash,
        int $cantidadFamiliares
    ): bool {

        $sql = "
            INSERT INTO usuarios
            (usuario, email, contraseña, fecha_registro, cantidad_familiares)
            VALUES (
                :usuario,
                :email,
                :password,
                NOW(),
                :cantidadFamiliares
            )
        ";

        $sentencia = $this->conn->prepare($sql);

        return $sentencia->execute([
            ':usuario' => $usuario,
            ':email' => $email,
            ':password' => $passwordHash,
            ':cantidadFamiliares' => $cantidadFamiliares
        ]);
    }

    public function login(string $email): array|false
    {
        $sql = "
            SELECT id, usuario, contraseña
            FROM usuarios
            WHERE email = :email
            LIMIT 1
        ";

        $sentencia = $this->conn->prepare($sql);

        $sentencia->execute([
            ':email' => $email
        ]);

        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($usuario === false) {
            return false;
        }

        return $usuario;
    }
}
?>
