<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nosotros - Kondorito</title>

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

    <!-- Fuente -->
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
                    <a href="nosotros.php" class="text-primary font-semibold">Nosotros</a>
                    <a href="contacto.php" class="hover:text-primary transition">Contacto</a>
                </nav>

                <div class="flex items-center gap-4">
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <details class="relative">
                            <summary class="flex cursor-pointer list-none items-center text-gray-700 hover:text-primary">
                                <i class="fas fa-user text-lg"></i>
                                <span class="ml-1 sm:hidden">Cuenta</span>
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
                        <a href="login.php" class="inline-flex items-center text-gray-700 hover:text-primary">
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
                    <a href="nosotros.php" class="text-primary font-semibold">Nosotros</a>
                    <a href="contacto.php" class="hover:text-primary transition">Contacto</a>
                </nav>
            </div>
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

<?php include 'cart_modal.php'; ?>
</body>
</html>
