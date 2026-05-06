<<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contacto - Kondorito</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
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

        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

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

                <a href="nosotros.php" class="hover:text-orange-500 transition">
                    Nosotros
                </a>

                <a href="contacto.php" class="text-orange-500 font-semibold">
                    Contacto
                </a>

            </nav>

        </div>

    </header>

    <!-- CONTACTO -->
    <section class="py-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-6">

            <!-- Encabezado -->
            <div class="text-center mb-20">

                <span class="bg-pink-200 text-amber-900 px-6 py-2 rounded-full font-semibold shadow-md">
                    Información de contacto
                </span>

                <h2 class="mt-6 text-5xl md:text-6xl font-bold font-display text-amber-900">
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
                <div class="bg-white rounded-[35px] shadow-2xl p-10 text-center hover:-translate-y-3 transition duration-300">

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
                <div class="bg-white rounded-[35px] shadow-2xl p-10 text-center hover:-translate-y-3 transition duration-300">

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
                <div class="bg-white rounded-[35px] shadow-2xl p-10 text-center hover:-translate-y-3 transition duration-300">

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
                <div class="bg-white rounded-[35px] shadow-2xl p-10 text-center hover:-translate-y-3 transition duration-300">

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

                <div class="flex justify-center gap-8">

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/p/Kondorito-postres-pasteles-100063476113980/?locale=es_LA"
                    target="_blank"
                    class="w-20 h-20 rounded-full bg-white shadow-xl flex items-center justify-center text-3xl text-amber-900 hover:bg-pink-200 hover:scale-110 transition duration-300">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/kondoritopostresypasteles/"
                    target="_blank"
                    class="w-20 h-20 rounded-full bg-white shadow-xl flex items-center justify-center text-3xl text-amber-900 hover:bg-pink-200 hover:scale-110 transition duration-300">

                        <i class="fab fa-instagram"></i>

                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/573155321183"
                    target="_blank"
                    class="w-20 h-20 rounded-full bg-white shadow-xl flex items-center justify-center text-3xl text-amber-900 hover:bg-pink-200 hover:scale-110 transition duration-300">

                        <i class="fab fa-whatsapp"></i>

                    </a>

                </div>

            </div>

        </div>

    </section>

</body>

</html>