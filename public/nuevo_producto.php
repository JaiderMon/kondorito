<?php

require_once __DIR__ . '/../conexion.php';

$producto = $_POST['producto'];

$sabor = $_POST['sabor'];

$tamano = $_POST['tamano'];

$cantidad = $_POST['cantidad'];

$query = "
INSERT INTO inventario
(producto, sabor, tamano, cantidad, fecha)

VALUES

(:producto, :sabor, :tamano, :cantidad, CURRENT_DATE)
";

$stmt = $pdo->prepare($query);
$stmt->execute([
    'producto' => $producto,
    'sabor' => $sabor,
    'tamano' => $tamano,
    'cantidad' => $cantidad
]);

header("Location: inventario.php");

?>