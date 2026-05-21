<?php

require_once __DIR__ . '/../conexion.php';


$id = $_POST['id'];
$estado = $_POST['estado_tracking'];
$fecha = $_POST['fecha'];



$query = "
UPDATE pedidos
SET estado_tracking = :estado
WHERE id = :id
";

$stmt = $pdo->prepare($query);

$stmt->execute([
    'estado' => $estado,
    'id' => $id
]);


header("Location: admin.php?fecha=" . $fecha);
exit();