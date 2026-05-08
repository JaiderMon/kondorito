<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nosotros - Kondorito</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <style>

        body {
            font-family: 'Poppins', sans-serif;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

    </style>

</head>

<body class="bg-gradient-to-br from-orange-50 via-pink-50 to-amber-50 text-gray-800">

    <!-- HEADER -->
    <header class="bg-white shadow-md sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center flex-wrap gap-4">

            <!-- Logo -->
            <a href="index.php" class="flex items-center gap-4">

                <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">

                    <i class="fas fa-birthday-cake text-2xl text-amber-900"></i>

                </div>

                <div>

                    <h1 class="text-3xl font-bold text-amber-900 font-display">
                        Kondorito
                    </h1>

                    <p class="text-sm text-gray-500">
                        Postres y Pasteles
                    </p>

                </div>

            </a>

            <!-- Navegación -->
            <nav class="hidden md:flex items-center gap-8 text-gray-700">

                <a href="index.php" class="hover:text-orange-500 transition">
                    Inicio
                </a>

                <a href="Catalogocompleto.php" class="hover:text-orange-500 transition">
                    Catálogo
                </a>

                <a href="nosotros.php" class="text-orange-500 font-semibold">
                    Nosotros
                </a>

                <a href="contacto.php" class="hover:text-orange-500 transition">
                    Contacto
                </a>

            </nav>

            <div class="flex items-center gap-4">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <a href="perfil.php" class="hidden sm:inline-flex items-center text-gray-700 hover:text-orange-500">
                        <i class="fas fa-user text-lg"></i>
                        <span class="ml-1">Hola, <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </a>
                <?php else: ?>
                    <a href="login.php" class="hidden sm:inline-flex items-center text-gray-700 hover:text-orange-500">
                        <i class="fas fa-user text-lg"></i>
                        <span class="ml-1">Mi cuenta</span>
                    </a>
                <?php endif; ?>

                <a href="Catalogocompleto.php#cart"
                   class="relative bg-[#ffcce6] hover:bg-pink-300 transition-colors rounded-full p-3">
                    <i class="fas fa-shopping-cart text-xl text-[#8b4513]"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>
            </div>

            <nav class="flex w-full justify-center gap-6 text-sm text-gray-700 md:hidden">
                <a href="index.php" class="hover:text-orange-500 transition">Inicio</a>
                <a href="Catalogocompleto.php" class="hover:text-orange-500 transition">Cat&aacute;logo</a>
                <a href="nosotros.php" class="text-orange-500 font-semibold">Nosotros</a>
                <a href="contacto.php" class="hover:text-orange-500 transition">Contacto</a>
            </nav>

        </div>

    </header>


    <!-- ================= NOSOTROS ================= -->
    <section class="py-12 md:py-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <div class="grid lg:grid-cols-2 gap-10 lg:gap-20 items-center">

                <!-- Imagen -->
                <div class="relative">

                    <div class="absolute -top-10 -left-10 w-72 h-72 bg-pink-300 rounded-full blur-3xl opacity-20"></div>

                    <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-yellow-200 rounded-full blur-3xl opacity-20"></div>

                    <img
                        src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1200&auto=format&fit=crop"
                        alt="Pastelería Kondorito"
                        class="relative w-full h-72 sm:h-96 lg:h-[600px] object-cover rounded-3xl lg:rounded-[40px] shadow-2xl border-4 sm:border-8 border-white">

                </div>

                <!-- Contenido -->
                <div>

                    <span class="bg-pink-200 text-amber-900 px-6 py-2 rounded-full font-semibold shadow-md">
                        Nuestra historia
                    </span>

                    <h2 class="mt-6 text-3xl sm:text-4xl md:text-6xl font-bold font-display text-amber-900 leading-tight">

                        Endulzamos
                        <span class="text-orange-500">
                            momentos especiales
                        </span>

                    </h2>

                    <p class="mt-8 text-lg text-gray-600 leading-relaxed">

                        En Kondorito creemos que cada celebración merece un toque especial.
                        Creamos tortas, postres y cupcakes artesanales utilizando ingredientes
                        frescos, diseños únicos y muchísimo amor.

                    </p>

                    <p class="mt-6 text-lg text-gray-600 leading-relaxed">

                        Nuestro objetivo es transformar cada pedido en una experiencia inolvidable,
                        acompañando cumpleaños, aniversarios y momentos importantes con sabores únicos.

                    </p>

                    <!-- Cards -->
                    <div class="grid sm:grid-cols-3 gap-4 sm:gap-6 mt-10 sm:mt-12">

                        <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 text-center hover:-translate-y-2 transition">

                            <div class="w-16 h-16 mx-auto rounded-full bg-pink-200 flex items-center justify-center mb-5">

                                <i class="fas fa-birthday-cake text-2xl text-amber-900"></i>

                            </div>

                            <h4 class="text-4xl font-bold text-orange-500">
                                +20
                            </h4>

                            <p class="mt-2 text-gray-600">
                                Años de experiencia
                            </p>

                        </div>

                        <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 text-center hover:-translate-y-2 transition">

                            <div class="w-16 h-16 mx-auto rounded-full bg-yellow-200 flex items-center justify-center mb-5">

                                <i class="fas fa-users text-2xl text-amber-900"></i>

                            </div>

                            <h4 class="text-4xl font-bold text-orange-500">
                                +1000
                            </h4>

                            <p class="mt-2 text-gray-600">
                                Clientes felices
                            </p>

                        </div>

                        <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 text-center hover:-translate-y-2 transition">

                            <div class="w-16 h-16 mx-auto rounded-full bg-pink-200 flex items-center justify-center mb-5">

                                <i class="fas fa-heart text-2xl text-amber-900"></i>

                            </div>

                            <h4 class="text-4xl font-bold text-orange-500">
                                100%
                            </h4>

                            <p class="mt-2 text-gray-600">
                                Con amor
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</body>
</html>
