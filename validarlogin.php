<?php
session_start();
require_once "conexion.php";

$correo = trim($_POST['correo'] ?? '');
$contrasena = $_POST['contrasena'] ?? ($_POST['password'] ?? '');

if ($correo === '' || $contrasena === '') {
    echo "Correo o contrasena incorrectos";
    exit();
}

$stmt = $conexion->prepare(
    "SELECT nombre, correo, password FROM usuarios WHERE correo = ? LIMIT 1"
);

if (!$stmt) {
    die("Error preparando la consulta: " . $conexion->error);
}

$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario && password_verify($contrasena, $usuario['password'])) {
    $_SESSION['usuario'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];

    header("Location: index.php");
    exit();
}

echo "Correo o contrasena incorrectos";

$stmt->close();
$conexion->close();
?>
