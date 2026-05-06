<?php
session_start();

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pasteleria");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$correo = $_POST['correo'];
$password = $_POST['password'];

// Consulta
$sql = "SELECT * FROM usuarios WHERE correo='$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $usuario = $result->fetch_assoc();

    // Verificar contraseña encriptada
    if (password_verify($password, $usuario['password'])) {

        // Crear sesión
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['correo'] = $usuario['correo'];

        // Redirigir al inicio
        header("Location: index.php");
        exit();

    } else {
        echo "<h3>❌ Contraseña incorrecta</h3>";
    }

} else {
    echo "<h3>❌ Usuario no encontrado</h3>";
}

$conn->close();
?>