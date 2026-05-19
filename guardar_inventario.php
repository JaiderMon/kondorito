<?php

require 'conexionpedidos.php';

$id = $_POST['id'];

$cantidad = $_POST['cantidad'];

$fecha = $_POST['fecha'];

$query = "
UPDATE inventario
SET cantidad = $cantidad
WHERE id = $id
AND fecha = '$fecha'
";

pg_query($conn, $query);

header("Location: inventario.php?fecha=$fecha");

?>