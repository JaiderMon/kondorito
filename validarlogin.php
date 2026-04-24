<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM usuarios WHERE correo='$correo' AND contrasena='$contrasena'";

$resultado = $conexion->query($sql);

if($resultado->num_rows > 0){

    $usuario = $resultado->fetch_assoc();
    $_SESSION['usuario'] = $usuario['nombre'];

    header("Location: index.php");

}else{

    echo "Correo o contraseña incorrectos";

}

?>