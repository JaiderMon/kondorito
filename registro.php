<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-yellow-100 via-pink-200 to-pink-300 px-4 py-8">

    <div class="bg-white/90 backdrop-blur-md p-6 sm:p-8 rounded-3xl shadow-2xl w-full max-w-sm border border-white/40">

        <!-- Icono -->
        <div class="flex justify-center mb-4">
            <div class="bg-yellow-200 p-4 rounded-full">
                <i class="fas fa-user-plus text-orange-600 text-3xl"></i>
            </div>
        </div>

        <!-- Título -->
        <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
            Crear cuenta
        </h2>

        <!-- Formulario -->
        <form action="procesar_registro.php" method="POST">

            <!-- Nombre -->
            <div class="mb-3">
                <label class="text-gray-600">Nombre</label>
                <input type="text" name="nombre" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400">
            </div>

            <!-- Correo -->
            <div class="mb-3">
                <label class="text-gray-600">Correo</label>
                <input type="email" name="correo" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400">
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label class="text-gray-600">Contraseña</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400">
            </div>

            <!-- Confirmar -->
            <div class="mb-4">
                <label class="text-gray-600">Confirmar contraseña</label>
                <input type="password" name="confirmar" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400">
            </div>

            <!-- Botón -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2 rounded-xl font-semibold hover:scale-105 transition">
                Registrarse
            </button>

        </form>

        <!-- Login -->
        <p class="text-center text-sm text-gray-600 mt-4">
            ¿Ya tienes cuenta?
            <a href="login.php" class="text-orange-500 font-semibold hover:underline">
                Inicia sesión
            </a>
        </p>

    </div>

</body>
</html>
