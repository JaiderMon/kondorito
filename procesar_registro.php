<?php
require_once "conexion.php";

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($nombre === '' || $correo === '' || $password === '' || $confirmar === '') {
    echo "Todos los campos son obligatorios";
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo "Correo invalido";
    exit();
}

if ($password !== $confirmar) {
    echo "Las contrasenas no coinciden";
    exit();
}

$stmt = $conexion->prepare("SELECT correo FROM usuarios WHERE correo = ? LIMIT 1");

if (!$stmt) {
    die("Error preparando la consulta: " . $conexion->error);
}

$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Este correo ya esta registrado";
    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conexion->prepare(
    "INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)"
);

if (!$stmt) {
    die("Error preparando la consulta: " . $conexion->error);
}

$stmt->bind_param("sss", $nombre, $correo, $password_hash);

if ($stmt->execute()) {
    header("Location: login.php");
    exit();
}

echo "Error: " . $stmt->error;

$stmt->close();
$conexion->close();
?>
