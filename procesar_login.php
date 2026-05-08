<?php
session_start();
require_once "conexion.php";

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if ($correo === '' || $password === '') {
    echo "<h3>Correo y contrasena son obligatorios</h3>";
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
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['usuario'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];

    header("Location: index.php");
    exit();
}

echo "<h3>Correo o contrasena incorrectos</h3>";

$stmt->close();
$conexion->close();
?>
