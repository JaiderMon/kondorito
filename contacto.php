<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contacto - Kondorito</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-pink': '#ffcce6',
                        'pastel-brown': '#8b4513',
                        'pastel-cream': '#fffaf0',
                        'pastel-yellow': '#fffacd',
                        'primary': '#d2691e',
                        'secondary': '#a0522d'
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script>
        window.cartUserKey = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : 'null'; ?>;
    </script>    
    <script src="assets/js/cart.js" defer></script>

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
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4 flex-wrap gap-4">

                <a href="index.php" class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-pastel-yellow flex items-center justify-center mr-3">
                        <i class="fas fa-birthday-cake text-2xl text-pastel-brown"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold font-display text-pastel-brown">Kondorito</h1>
                        <p class="text-sm text-gray-600">Postres y Pasteles</p>
                    </div>
                </a>

                <nav class="hidden lg:flex items-center gap-8 text-gray-700">
                    <a href="index.php" class="hover:text-primary transition">Inicio</a>
                    <a href="Catalogocompleto.php" class="hover:text-primary transition">Cat&aacute;logo</a>
                    <a href="nosotros.php" class="hover:text-primary transition">Nosotros</a>
                    <a href="contacto.php" class="text-primary font-semibold">Contacto</a>
                </nav>

                <div class="flex items-center gap-4">
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <details class="relative">
                            <summary class="flex cursor-pointer list-none items-center text-gray-700 hover:text-primary">
                                <i class="fas fa-user text-lg"></i>
                                <span class="ml-1 hidden sm:inline">Hola, <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </summary>
                            <div class="absolute right-0 mt-3 w-56 rounded-2xl border border-pink-100 bg-white p-2 shadow-xl">
                                <a href="perfil.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary">
                                    <i class="fas fa-user-cog"></i>
                                    Configuraci&oacute;n perfil
                                </a>
                                <a href="mis_pedidos.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary">
                                    <i class="fas fa-receipt"></i>
                                    Mis pedidos
                                </a>
                                <a href="logout.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-red-500 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar sesi&oacute;n
                                </a>
                            </div>
                        </details>
                    <?php else: ?>
                        <a href="login.php" class="hidden sm:inline-flex items-center text-gray-700 hover:text-primary">
                            <i class="fas fa-user text-lg"></i>
                            <span class="ml-1">Mi cuenta</span>
                        </a>
                    <?php endif; ?>

                    <a href="#cart"
                       data-cart-button
                       class="relative bg-pastel-pink hover:bg-pink-300 transition-colors rounded-full p-3">
                        <i class="fas fa-shopping-cart text-xl text-pastel-brown"></i>
                        <span data-cart-count class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                </div>

                <nav class="flex w-full flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-gray-700 lg:hidden">
                    <a href="index.php" class="hover:text-primary transition">Inicio</a>
                    <a href="Catalogocompleto.php" class="hover:text-primary transition">Cat&aacute;logo</a>
                    <a href="nosotros.php" class="hover:text-primary transition">Nosotros</a>
                    <a href="contacto.php" class="text-primary font-semibold">Contacto</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- CONTACTO -->
    <section class="py-12 md:py-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <!-- Encabezado -->
            <div class="text-center mb-12 md:mb-20">

                <span class="bg-pink-200 text-amber-900 px-6 py-2 rounded-full font-semibold shadow-md">
                    Información de contacto
                </span>

                <h2 class="mt-6 text-3xl sm:text-4xl md:text-6xl font-bold font-display text-amber-900">
                    Contáctanos 🍰
                </h2>

                <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Estamos disponibles para ayudarte con pedidos,
                    cotizaciones y cualquier duda sobre nuestros productos.
                </p>

            </div>

            <!-- Cards -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Dirección -->
                <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 text-center hover:-translate-y-3 transition duration-300">

                    <div class="w-20 h-20 mx-auto rounded-full bg-pink-200 flex items-center justify-center mb-6">

                        <i class="fas fa-map-marker-alt text-3xl text-amber-900"></i>

                    </div>

                    <h3 class="text-2xl font-bold text-amber-900 mb-4">
                        Dirección
                    </h3>

                    <p class="text-gray-600 text-lg leading-relaxed">
                        Calle 30 #8e 31<br>
                        La Cumbre, Floridablanca 
                    </p>

                </div>

                <!-- Teléfono -->
                <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 text-center hover:-translate-y-3 transition duration-300">

                    <div class="w-20 h-20 mx-auto rounded-full bg-yellow-200 flex items-center justify-center mb-6">

                        <i class="fas fa-phone text-3xl text-amber-900"></i>

                    </div>

                    <h3 class="text-2xl font-bold text-amber-900 mb-4">
                        Teléfono
                    </h3>

                    <p class="text-gray-600 text-lg">
                        +57 315 532 1183
                    </p>

                </div>

                <!-- Correo -->
                <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 text-center hover:-translate-y-3 transition duration-300">

                    <div class="w-20 h-20 mx-auto rounded-full bg-pink-200 flex items-center justify-center mb-6">

                        <i class="fas fa-envelope text-3xl text-amber-900"></i>

                    </div>

                    <h3 class="text-2xl font-bold text-amber-900 mb-4">
                        Correo
                    </h3>

                    <p class="text-gray-600 text-lg break-words">
                        gerenciakondorito@gmail.com
                    </p>

                </div>

                <!-- Horarios -->
                <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 text-center hover:-translate-y-3 transition duration-300">

                    <div class="w-20 h-20 mx-auto rounded-full bg-yellow-200 flex items-center justify-center mb-6">

                        <i class="fas fa-clock text-3xl text-amber-900"></i>

                    </div>

                    <h3 class="text-2xl font-bold text-amber-900 mb-4">
                        Horarios
                    </h3>

                    <p class="text-gray-600 text-lg leading-relaxed">
                        Lun - Sáb<br>
                        8:00 AM - 7:00 PM
                    </p>

                </div>

            </div>

            <!-- Redes -->
            <div class="mt-20 text-center">

                <h3 class="text-3xl font-bold font-display text-amber-900 mb-8">
                    Síguenos en redes sociales
                </h3>

                <div class="flex flex-wrap justify-center gap-5 sm:gap-8">

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/p/Kondorito-postres-pasteles-100063476113980/?locale=es_LA"
                    target="_blank"
                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white shadow-xl flex items-center justify-center text-2xl sm:text-3xl text-amber-900 hover:bg-pink-200 hover:scale-110 transition duration-300">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/kondoritopostresypasteles/"
                    target="_blank"
                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white shadow-xl flex items-center justify-center text-2xl sm:text-3xl text-amber-900 hover:bg-pink-200 hover:scale-110 transition duration-300">

                        <i class="fab fa-instagram"></i>

                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/573155321183"
                    target="_blank"
                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white shadow-xl flex items-center justify-center text-2xl sm:text-3xl text-amber-900 hover:bg-pink-200 hover:scale-110 transition duration-300">

                        <i class="fab fa-whatsapp"></i>

                    </a>

                </div>

            </div>

        </div>

    </section>

<?php include 'cart_modal.php'; ?>
</body>

</html>
