<?php

require_once __DIR__ . '/../services/AuthService.php';

class AuthController
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(
        string $usuario,
        string $email,
        string $password,
        int $cantidadFamiliares
    ): array {
        return $this->authService->register(
            $usuario,
            $email,
            $password,
            $cantidadFamiliares
        );
    }

    public function login(
        string $email,
        string $password,
    ): array {
        return $this->authService->login(
            $email,
            $password
        );
    }
}

?>