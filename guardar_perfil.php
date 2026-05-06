<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pasteleria");

$correo = $_SESSION['correo'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$telefono = $_POST['telefono'];

$sql = "UPDATE usuarios 
        SET direccion='$direccion', ciudad='$ciudad', telefono='$telefono'
        WHERE correo='$correo'";

$conn->query($sql);

header("Location: index.php");
exit();
?>