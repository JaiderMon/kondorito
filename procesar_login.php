<?php
session_start();
require_once "conexion.php";

$correo = trim($_POST['correo'] ?? '');
$password = $_POST['password'] ?? '';

if ($correo === '' || $password === '') {
    echo "<h3>Correo y contrasena son obligatorios</h3>";
    exit();
}

$stmt = $pdo->prepare(
    "SELECT nombre, correo, password FROM usuarios WHERE correo = :correo LIMIT 1"
);
$stmt->execute(['correo' => $correo]);
$usuario = $stmt->fetch();

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['usuario'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];

    header("Location: index.php");
    exit();
}

echo "<h3>Correo o contrasena incorrectos</h3>";
?>
