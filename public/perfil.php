<?php
session_start();
require_once __DIR__ . '/../conexion.php';

if (!isset($_SESSION['usuario'], $_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

$correo = $_SESSION['correo'];
$stmt = $pdo->prepare(
    "SELECT nombre, correo, direccion, ciudad, telefono FROM usuarios WHERE correo = :correo LIMIT 1"
);
$stmt->execute(['correo' => $correo]);
$usuario = $stmt->fetch();

if (!$usuario) {
    session_destroy();
    header("Location: login.php");
    exit();
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-r from-yellow-100 via-pink-200 to-pink-300 flex items-center justify-center px-4 py-8">

<div class="bg-white p-6 sm:p-8 rounded-3xl shadow-xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-orange-600 text-center mb-4">
        Mi Perfil
    </h2>

    <form action="guardar_perfil.php" method="POST">

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" value="<?php echo e($usuario['nombre'] ?? ''); ?>" disabled
                class="w-full px-3 py-2 border rounded-lg bg-gray-100">
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="text" value="<?php echo e($usuario['correo'] ?? ''); ?>" disabled
                class="w-full px-3 py-2 border rounded-lg bg-gray-100">
        </div>

        <div class="mb-3">
            <label>Direcci&oacute;n</label>
            <input type="text" name="direccion" value="<?php echo e($usuario['direccion'] ?? ''); ?>"
                class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-3">
            <label>Ciudad</label>
            <select name="ciudad" class="w-full px-3 py-2 border rounded-lg">

                <?php
                $ciudades = ["Piedecuesta", "Girón", "Bucaramanga", "Floridablanca"];
                foreach ($ciudades as $c) {
                    $selected = (($usuario['ciudad'] ?? '') === $c) ? "selected" : "";
                    echo '<option value="' . e($c) . '" ' . $selected . '>' . e($c) . '</option>';
                }
                ?>

            </select>
        </div>

        <div class="mb-4">
            <label>Tel&eacute;fono</label>
            <input type="text" name="telefono" value="<?php echo e($usuario['telefono'] ?? ''); ?>"
                class="w-full px-3 py-2 border rounded-lg">
        </div>

        <button type="submit"
            class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">
            Guardar cambios
        </button>

    </form>

    <a href="logout.php" class="block text-center text-red-500 mt-4">
        Cerrar sesi&oacute;n
    </a>

</div>

</body>
</html>
