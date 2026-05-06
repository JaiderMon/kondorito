<?php
$conn = new mysqli("localhost", "root", "", "pasteleria");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = $_POST['password'];
$confirmar = $_POST['confirmar'];

// Validar contraseñas
if ($password != $confirmar) {
    echo "Las contraseñas no coinciden";
    exit();
}

// Encriptar contraseña 🔐
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$sql = "INSERT INTO usuarios (nombre, correo, password)
        VALUES ('$nombre', '$correo', '$password_hash')";

if ($conn->query($sql) === TRUE) {
    header("Location: login.php");
} else {
    echo "Error: " . $conn->error;
}
?>