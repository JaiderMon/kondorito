<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-yellow-100 via-pink-200 to-pink-300 px-4 py-8">

    <div class="bg-white/90 backdrop-blur-md p-6 sm:p-8 rounded-3xl shadow-2xl w-full max-w-sm border border-white/40">

        <div class="flex justify-center mb-4">
            <div class="bg-yellow-200 p-4 rounded-full">
                <i class="fas fa-user-plus text-orange-600 text-3xl"></i>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
            Crear cuenta
        </h2>

        <?php if (!empty($_GET['error'])): ?>
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">
                <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <form action="procesar_registro.php" method="POST" id="registroForm" novalidate>

            <div class="mb-3">
                <label class="text-gray-600">Nombre</label>
                <input type="text" name="nombre" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <div class="mb-3">
                <label class="text-gray-600">Correo</label>
                <input type="email" name="correo" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <div class="mb-3">
                <label class="text-gray-600">Contrase&ntilde;a</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="text-gray-600">Confirmar contrase&ntilde;a</label>
                <input type="password" name="confirmar" id="confirmar" required
                    class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                <p id="passwordError" class="hidden mt-2 text-sm text-red-600">
                    Las contrase&ntilde;as no coinciden.
                </p>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-2 rounded-xl font-semibold hover:scale-105 transition">
                Registrarse
            </button>

        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            &iquest;Ya tienes cuenta?
            <a href="login.php" class="text-orange-500 font-semibold hover:underline">
                Inicia sesi&oacute;n
            </a>
        </p>

    </div>

    <script>
        const form = document.getElementById('registroForm');
        const password = document.getElementById('password');
        const confirmar = document.getElementById('confirmar');
        const passwordError = document.getElementById('passwordError');

        function validarPasswords() {
            const noCoinciden = confirmar.value !== '' && password.value !== confirmar.value;

            passwordError.classList.toggle('hidden', !noCoinciden);
            confirmar.classList.toggle('border-red-400', noCoinciden);
            confirmar.classList.toggle('focus:ring-red-400', noCoinciden);

            return !noCoinciden;
        }

        password.addEventListener('input', validarPasswords);
        confirmar.addEventListener('input', validarPasswords);

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                return;
            }

            if (!validarPasswords()) {
                event.preventDefault();
                confirmar.focus();
            }
        });
    </script>

</body>
</html>
