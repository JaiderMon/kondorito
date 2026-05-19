<?php
require_once "conexion.php";

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $correo = trim($_POST['correo']);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $stmt->execute(['correo' => $correo]);

    $usuario = $stmt->fetch();

    if ($usuario) {

        $nuevaPassword = password_hash($_POST['nueva_password'], PASSWORD_DEFAULT);

        $update = $pdo->prepare("
            UPDATE usuarios 
            SET password = :password 
            WHERE correo = :correo
        ");

        $update->execute([
            'password' => $nuevaPassword,
            'correo' => $correo
        ]);

        header("Location: login.php?error=password_actualizada");
        exit();

    } else {
        $mensaje = "El correo no existe.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-yellow-100 via-pink-200 to-pink-300 px-4">

    <div class="bg-white p-8 rounded-3xl shadow-2xl w-full max-w-sm">

        <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
            Recuperar Contraseña
        </h2>

        <?php if ($mensaje != ""): ?>
            <div class="mb-4 bg-red-100 text-red-600 p-3 rounded-xl text-sm">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-4">
                <label class="block mb-1 text-gray-600">
                    Correo
                </label>

                <input 
                    type="email" 
                    name="correo" 
                    required
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            <div class="mb-6">
                <label class="block mb-1 text-gray-600">
                    Nueva contraseña
                </label>

                <input 
                    type="password" 
                    name="nueva_password" 
                    required
                    class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-orange-400 outline-none">
            </div>

            <button 
                type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-xl font-semibold transition">
                Restablecer Contraseña
            </button>

        </form>

        <p class="text-center mt-4 text-sm">
            <a href="login.php" class="text-orange-500 hover:underline">
                Volver al login
            </a>
        </p>

    </div>

</body>
</html>