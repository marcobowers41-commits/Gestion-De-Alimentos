<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../services/LoginUpService.php';

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(
        string $usuario,
        string $email,
        string $password,
        int $cantidadFamiliares
    ): array {

        // Validar campos
        if (
            empty($usuario) ||
            empty($email) ||
            empty($password)
        ) {
            return [
                'status' => 'error',
                'message' => 'Completá todos los campos.'
            ];
        }

        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'El email no es válido.'
            ];
        }

        // Verificar si ya existe el email
        if ($this->userRepository->existsByEmail($email)) {
            return [
                'status' => 'error',
                'message' => 'El email ya está registrado.'
            ];
        }

        // Verificar si ya existe el usuario
        if ($this->userRepository->existsByUsername($usuario)) {
            return [
                'status' => 'error',
                'message' => 'El nombre de usuario ya está registrado.'
            ];
        }

        // Hashear contraseña
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Verificar cantidad de familiares

        if ($cantidadFamiliares < 1){
            return [
                'status' => 'error',
                'message' => 'La familia debe tener almenos 1 miembro'
            ];
        }

        // Crear usuario
        $creado = $this->userRepository->create(
            $usuario,
            $email,
            $passwordHash,
            $cantidadFamiliares
        );

        if (!$creado) {
            return [
                'status' => 'error',
                'message' => 'No se pudo crear la cuenta.'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Cuenta creada correctamente.'
        ];
    }

    public function login(
        string $email,
        string $password
    ): array {


        // Validar campos
        if (
            empty($email) ||
            empty($password)
        ) {
            return [
                'status' => 'error',
                'message' => 'Completá todos los campos.'
            ];
        }

        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'El email no es válido.'
            ];
        }


        // Conseguir datos de inicio de sesión
        $inicio = $this->userRepository->login(
            $email
        );

        if (!$inicio) {
            return [
                'status' => 'error',
                'message' => 'Contraseña o email incorrectos' // No existe la cuenta
            ];
        }

        if (!password_verify($password, $inicio['contraseña'])) {
            return [
                'status' => 'error',
                'message' => 'Contraseña o email incorrectos'
            ];
        }

        $loginUpService = new LoginUpService();

        $loginUpService->iniciarSesion($inicio['id'], $inicio['usuario']);

        return [
            'status' => 'success',
            'message' => 'Inicio de sesión correcto.'
        ];
    }
}

?>