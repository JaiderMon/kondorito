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

$stmt = $pdo->prepare("SELECT correo FROM usuarios WHERE correo = :correo LIMIT 1");
$stmt->execute(['correo' => $correo]);

if ($stmt->fetch()) {
    echo "Este correo ya esta registrado";
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare(
    "INSERT INTO usuarios (nombre, correo, password) VALUES (:nombre, :correo, :password)"
);

$stmt->execute([
    'nombre' => $nombre,
    'correo' => $correo,
    'password' => $password_hash,
]);

header("Location: login.php");
exit();
?>
