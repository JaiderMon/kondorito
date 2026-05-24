<?php

require_once __DIR__ . '/../conexion.php';

$id = $_GET['id'];

$query = "DELETE FROM inventario WHERE id = :id";

$stmt = $pdo->prepare($query);
$stmt->execute([
    'id' => $id
]);

header("Location: inventario.php");

?>