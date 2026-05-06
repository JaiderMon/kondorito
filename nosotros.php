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
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

                <a href="nosotros.php" class="text-orange-500 font-semibold">
                    Nosotros
                </a>

                <a href="contacto.php" class="hover:text-orange-500 transition">
                    Contacto
                </a>

            </nav>

        </div>

    </header>


    <!-- ================= NOSOTROS ================= -->
    <section class="py-24 overflow-hidden">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid lg:grid-cols-2 gap-20 items-center">

                <!-- Imagen -->
                <div class="relative">

                    <div class="absolute -top-10 -left-10 w-72 h-72 bg-pink-300 rounded-full blur-3xl opacity-20"></div>

                    <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-yellow-200 rounded-full blur-3xl opacity-20"></div>

                    <img
                        src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1200&auto=format&fit=crop"
                        alt="Pastelería Kondorito"
                        class="relative w-full h-[600px] object-cover rounded-[40px] shadow-2xl border-8 border-white">

                </div>

                <!-- Contenido -->
                <div>

                    <span class="bg-pink-200 text-amber-900 px-6 py-2 rounded-full font-semibold shadow-md">
                        Nuestra historia
                    </span>

                    <h2 class="mt-6 text-5xl md:text-6xl font-bold font-display text-amber-900 leading-tight">

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
                    <div class="grid sm:grid-cols-3 gap-6 mt-12">

                        <div class="bg-white rounded-3xl shadow-xl p-8 text-center hover:-translate-y-2 transition">

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

                        <div class="bg-white rounded-3xl shadow-xl p-8 text-center hover:-translate-y-2 transition">

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

                        <div class="bg-white rounded-3xl shadow-xl p-8 text-center hover:-translate-y-2 transition">

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