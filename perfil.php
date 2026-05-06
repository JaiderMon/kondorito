<?php
session_start();

$conn = new mysqli("localhost", "root", "", "pasteleria");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario
$correo = $_SESSION['correo'];
$sql = "SELECT * FROM usuarios WHERE correo='$correo'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-r from-yellow-100 via-pink-200 to-pink-300 flex items-center justify-center">

<div class="bg-white p-8 rounded-3xl shadow-xl w-[400px]">

    <h2 class="text-2xl font-bold text-orange-600 text-center mb-4">
        Mi Perfil
    </h2>

    <form action="guardar_perfil.php" method="POST">

        <!-- Nombre -->
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" value="<?php echo $usuario['nombre']; ?>" disabled
                class="w-full px-3 py-2 border rounded-lg bg-gray-100">
        </div>

        <!-- Correo -->
        <div class="mb-3">
            <label>Correo</label>
            <input type="text" value="<?php echo $usuario['correo']; ?>" disabled
                class="w-full px-3 py-2 border rounded-lg bg-gray-100">
        </div>

        <!-- Dirección -->
        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" value="<?php echo $usuario['direccion']; ?>"
                class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Ciudad -->
        <div class="mb-3">
            <label>Ciudad</label>
            <select name="ciudad" class="w-full px-3 py-2 border rounded-lg">

                <?php
                $ciudades = ["Piedecuesta", "Girón", "Bucaramanga", "Floridablanca"];
                foreach ($ciudades as $c) {
                    $selected = ($usuario['ciudad'] == $c) ? "selected" : "";
                    echo "<option $selected>$c</option>";
                }
                ?>

            </select>
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="<?php echo $usuario['telefono']; ?>"
                class="w-full px-3 py-2 border rounded-lg">
        </div>

        <!-- Botón -->
        <button type="submit"
            class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">
            Guardar cambios
        </button>

    </form>

    <a href="logout.php" class="block text-center text-red-500 mt-4">
        Cerrar sesión
    </a>

</div>

</body>
</html>