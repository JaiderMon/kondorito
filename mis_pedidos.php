<?php
session_start();

if (!isset($_SESSION['usuario'], $_SESSION['correo'])) {
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
    <title>Mis pedidos - Kondorito</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        window.cartUserKey = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : 'null'; ?>;
    </script>    
    <script src="assets/js/cart.js" defer></script>

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
                    },
                    fontFamily: {
                        'display': ['"Playfair Display"', 'serif'],
                        'body': ['"Open Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-pastel-cream font-body text-gray-800">

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
                    <a href="contacto.php" class="hover:text-primary transition">Contacto</a>
                </nav>

                <div class="flex items-center gap-4">
                    <details class="relative">
                        <summary class="flex cursor-pointer list-none items-center text-gray-700 hover:text-primary">
                            <i class="fas fa-user text-lg"></i>
                            <span class="ml-1 hidden sm:inline">Hola, <?php echo e($_SESSION['usuario']); ?></span>
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </summary>

                        <div class="absolute right-0 mt-3 w-56 rounded-2xl border border-pink-100 bg-white p-2 shadow-xl">
                            <a href="perfil.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary">
                                <i class="fas fa-user-cog"></i>
                                Configuraci&oacute;n perfil
                            </a>
                            <a href="mis_pedidos.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-primary bg-orange-50">
                                <i class="fas fa-receipt"></i>
                                Mis pedidos
                            </a>
                            <a href="logout.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-red-500 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar sesi&oacute;n
                            </a>
                        </div>
                    </details>

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
                    <a href="contacto.php" class="hover:text-primary transition">Contacto</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section class="bg-gradient-to-r from-pastel-pink via-white to-pastel-yellow py-14 md:py-20">
            <div class="container mx-auto px-4 text-center">
                <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-md mb-5">
                    <i class="fas fa-receipt text-3xl text-pastel-brown"></i>
                </span>
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-pastel-brown">
                    Mis pedidos
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                    Consulta el estado de tus compras y revisa tu historial de pedidos.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div class="grid gap-8 lg:grid-cols-2">

                <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-xl">
                    <div class="mb-6 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-display text-3xl font-bold text-pastel-brown">
                                Pedidos en curso
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Aqu&iacute; aparecer&aacute;n los pedidos pendientes, en preparaci&oacute;n o en camino.
                            </p>
                        </div>
                        <span class="rounded-full bg-pastel-yellow px-4 py-2 text-sm font-semibold text-pastel-brown">
                            0
                        </span>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-pink-200 bg-pink-50/50 px-6 py-12 text-center">
                        <i class="fas fa-box-open text-5xl text-pink-300"></i>
                        <h4 class="mt-5 text-xl font-bold text-pastel-brown">
                            A&uacute;n no tienes pedidos en curso
                        </h4>
                        <p class="mt-2 text-gray-500">
                            Cuando realices una compra, podr&aacute;s seguir aqu&iacute; su estado.
                        </p>
                        <a href="Catalogocompleto.php" class="mt-6 inline-flex rounded-full bg-primary px-6 py-3 font-semibold text-white shadow-md transition hover:bg-secondary">
                            Ver cat&aacute;logo
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 sm:p-8 shadow-xl">
                    <div class="mb-6 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-display text-3xl font-bold text-pastel-brown">
                                Historial
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Aqu&iacute; aparecer&aacute;n los pedidos entregados o cancelados.
                            </p>
                        </div>
                        <span class="rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-500">
                            0
                        </span>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
                        <i class="fas fa-history text-5xl text-gray-300"></i>
                        <h4 class="mt-5 text-xl font-bold text-pastel-brown">
                            A&uacute;n no tienes historial de pedidos
                        </h4>
                        <p class="mt-2 text-gray-500">
                            Tus pedidos finalizados se guardar&aacute;n en esta secci&oacute;n.
                        </p>
                    </div>
                </div>

            </div>

            <div class="mt-8 rounded-3xl bg-amber-50 p-6 text-sm text-amber-900 shadow-sm">
                <div class="flex gap-3">
                    <i class="fas fa-map-marker-alt mt-1"></i>
                    <p>
                        La opci&oacute;n de tracking en tiempo real se activar&aacute; cuando conectemos los pedidos reales con los domiciliarios.
                    </p>
                </div>
            </div>
        </section>
    </main>

<?php include 'cart_modal.php'; ?>
</body>
</html>
