<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

$correo = $_SESSION['correo'];
$direccion = trim($_POST['direccion'] ?? '');
$ciudad = trim($_POST['ciudad'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');

$ciudadesPermitidas = ["Piedecuesta", "Girón", "Bucaramanga", "Floridablanca"];

if (!in_array($ciudad, $ciudadesPermitidas, true)) {
    echo "Ciudad invalida";
    exit();
}

$stmt = $conexion->prepare(
    "UPDATE usuarios SET direccion = ?, ciudad = ?, telefono = ? WHERE correo = ?"
);

if (!$stmt) {
    die("Error preparando la consulta: " . $conexion->error);
}

$stmt->bind_param("ssss", $direccion, $ciudad, $telefono, $correo);
$stmt->execute();
$stmt->close();
$conexion->close();

header("Location: index.php");
exit();
?>
