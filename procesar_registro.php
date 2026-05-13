<?php
require_once "conexion.php";

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($nombre === '' || $correo === '' || $password === '' || $confirmar === '') {
    header("Location: registro.php?error=" . urlencode("Todos los campos son obligatorios"));
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: registro.php?error=" . urlencode("Correo invalido"));
    exit();
}

if ($password !== $confirmar) {
    header("Location: registro.php?error=" . urlencode("Las contrasenas no coinciden"));
    exit();
}

$stmt = $pdo->prepare("SELECT correo FROM usuarios WHERE correo = :correo LIMIT 1");
$stmt->execute(['correo' => $correo]);

if ($stmt->fetch()) {
    header("Location: registro.php?error=" . urlencode("Este correo ya esta registrado"));
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
