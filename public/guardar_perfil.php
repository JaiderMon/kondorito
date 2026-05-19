<?php
session_start();
require_once __DIR__ . '/../conexion.php';

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

$stmt = $pdo->prepare(
    "UPDATE usuarios
     SET direccion = :direccion, ciudad = :ciudad, telefono = :telefono
     WHERE correo = :correo"
);

$stmt->execute([
    'direccion' => $direccion,
    'ciudad' => $ciudad,
    'telefono' => $telefono,
    'correo' => $correo,
]);

header("Location: index.php");
exit();
?>
