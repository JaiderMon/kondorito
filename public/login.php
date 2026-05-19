<?php
$error = $_GET['error'] ?? '';
$mensajeError = '';

if ($error === 'campos') {
    $mensajeError = 'Debes completar el correo y la contraseña.';
}

if ($error === 'credenciales') {
    $mensajeError = 'El correo o la contraseña son incorrectos.';
}

if ($error === 'correo_no_existe') {
    $mensajeError = 'El correo ingresado no existe.';
}

if ($error === 'password_actualizada') {
    $mensajeError = 'Contraseña actualizada correctamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-yellow-100 via-pink-200 to-pink-300 px-4 py-8">

    <!-- Contenedor -->
    <div class="bg-white/90 backdrop-blur-md p-6 sm:p-8 rounded-3xl shadow-2xl w-full max-w-sm border border-white/40">

        <!-- Icono -->
        <div class="flex justify-center mb-4">
            <div class="bg-yellow-200 p-5 rounded-full">
                <i class="fas fa-birthday-cake text-orange-600 text-4xl"></i>
            </div>
        </div>

        <!-- Título -->
        <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
            Iniciar Sesión
        </h2>

        <!-- Mensajes -->
        <?php if ($mensajeError !== ''): ?>
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                <i class="fas fa-circle-exclamation mr-2"></i>
                <?php echo htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form action="procesar_login.php" method="POST">

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-1">Correo</label>
                <input 
                    type="email" 
                    name="correo" 
                    required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:outline-none transition">
            </div>

            <!-- Password -->
            <div class="mb-2">
                <label class="block text-gray-600 mb-1">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:outline-none transition">
            </div>

            <!-- Olvidaste contraseña -->
            <div class="text-right mb-5">
                <a href="recuperar_contraseña.php"
                   class="text-sm text-orange-500 hover:text-orange-600 hover:underline">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <!-- Botón -->
            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2 rounded-xl font-semibold hover:scale-105 transition-transform shadow-md">
                Ingresar
            </button>

        </form>

        <!-- Separador -->
        <div class="flex items-center my-5">
            <hr class="flex-1 border-gray-300">
            <span class="px-2 text-gray-400 text-sm">o</span>
            <hr class="flex-1 border-gray-300">
        </div>

        <!-- Registro -->
        <p class="text-center text-sm text-gray-600">
            ¿No tienes cuenta?
            <a href="registro.php" class="text-orange-500 font-semibold hover:underline">
                Regístrate
            </a>
        </p>

    </div>

</body>
</html>
