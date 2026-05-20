<?php

require_once __DIR__ . '/conexion.php';

$id = $_POST['id'];

$cantidad = $_POST['cantidad'];

$fecha = $_POST['fecha'];

$query = "
UPDATE inventario
SET cantidad = :cantidad
WHERE id = :id
AND fecha = :fecha
";

$stmt = $pdo->prepare($query);
$stmt->execute([
    'cantidad' => $cantidad,
    'id' => $id,
    'fecha' => $fecha
]);

header("Location: inventario.php?fecha=$fecha");

?>