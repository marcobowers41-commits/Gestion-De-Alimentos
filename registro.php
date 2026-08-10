<?php
// registro.php
header('Content-Type: application/json'); // Le avisa a JS que la respuesta es un JSON

require_once 'conexion.php';
require_once 'loginup.php';

// Obtener los datos enviados desde el formulario
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$cantidadFamiliares = isset($_POST['cantidadFamiliares']) ? intval($_POST['cantidadFamiliares']) : 0;

// Verificar que los campos requeridos no estén vacíos
if (empty($email) || empty($nombre) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor, completá todos los campos obligatorios.']);
    exit();
}

// Verificar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'El correo electrónico no tiene un formato válido.']);
    exit();
}

// Cifrar la contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Verificar si el usuario ya existe
$sql = "SELECT id FROM usuarios WHERE email = ?";
$sentenciaPreparada = $conn->prepare($sql);
$sentenciaPreparada->bind_param("s", $email);
$sentenciaPreparada->execute();
$resultado = $sentenciaPreparada->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'El correo electrónico ya está registrado.']);
    $sentenciaPreparada->close();
    $conn->close();
    exit();
}

// Cerrar la sentencia de verificación antes de abrir la de inserción
$sentenciaPreparada->close();

// Conseguir tiempo

$fechaActual = date("Y-m-d H:i:s");

// Insertar el nuevo usuario
$sql = "INSERT INTO usuarios (usuario, email, contraseña, cantidad_familiares, fecha_registro) VALUES (?, ?, ?, ?, ?)";
$sentenciaPreparada = $conn->prepare($sql);
$sentenciaPreparada->bind_param("sssis", $nombre, $email, $passwordHash, $cantidadFamiliares, $fechaActual);

if ($sentenciaPreparada->execute()) {
    $idNuevoUsuario = $conn->insert_id; 

    // LLamamos a la función de loginup.php para iniciar la sesión
    iniciarSesion($idNuevoUsuario, $nombre);

    // Cerramos conexiones antes de enviar la respuesta exitosa
    $sentenciaPreparada->close();
    $conn->close();

    // Respondemos con éxito y la URL de redirección para tu JS
    echo json_encode([
        'status' => 'success',
        'message' => 'Usuario registrado correctamente.',
        'redirect' => 'index.php'
    ]);
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al registrar el usuario en el sistema.']);
    $sentenciaPreparada->close();
    $conn->close();
    exit();
}
?>
