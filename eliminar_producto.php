<?php

require 'conexionpedidos.php';

$id = $_GET['id'];

$query = "DELETE FROM inventario WHERE id = $id";

pg_query($conn, $query);

header("Location: inventario.php");

?>