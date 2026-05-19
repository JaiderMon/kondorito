<?php

require 'conexionpedidos.php';

$producto = $_POST['producto'];

$sabor = $_POST['sabor'];

$tamano = $_POST['tamano'];

$cantidad = $_POST['cantidad'];

$query = "
INSERT INTO inventario
(producto, sabor, tamano, cantidad, fecha)

VALUES

('$producto', '$sabor', '$tamano', $cantidad, CURRENT_DATE)
";

pg_query($conn, $query);

header("Location: inventario.php");

?>