<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T&eacute;rminos y privacidad - Kondorito</title>
    <meta name="description" content="T&eacute;rminos, condiciones, privacidad y cookies de Kondorito Postres y Pasteles.">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        window.cartRequiresLogin = true;
        window.cartUserLoggedIn = <?php echo isset($_SESSION['usuario']) ? 'true' : 'false'; ?>;
        window.cartUserKey = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : 'null'; ?>;
        window.cartCheckoutUrl = 'pago.php';
    </script>
    <script src="assets/js/cart.js?v=2" defer></script>
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
    <style>
        .legal-section {
            scroll-margin-top: 135px;
        }
    </style>
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
                    <?php if (isset($_SESSION['usuario'])): ?>
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

                    <a href="#cart" data-cart-button class="relative bg-pastel-pink hover:bg-pink-300 transition-colors rounded-full p-3">
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
        <section id="legal-hero" class="bg-gradient-to-r from-pastel-pink via-white to-pastel-yellow py-14 md:py-20">
            <div class="container mx-auto px-4 text-center">
                <span class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white shadow-md mb-5">
                    <i class="fas fa-file-contract text-3xl text-pastel-brown"></i>
                </span>
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-pastel-brown">
                    Términos y privacidad
                </h2>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                    Información sobre el uso de la web, pedidos, pagos, datos personales y cookies.
                </p>
            </div>
        </section>

        <section class="container mx-auto px-4 py-12">
            <div class="mx-auto max-w-5xl space-y-8">
                <article id="terminos" class="legal-section rounded-3xl bg-white p-6 sm:p-8 shadow-xl">
                    <h3 class="font-display text-3xl font-bold text-pastel-brown">Términos y condiciones</h3>
                    <div class="mt-5 space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            Al usar la plataforma de Kondorito Postres y Pasteles, el usuario acepta utilizar la web para consultar productos, registrar pedidos y realizar pagos de manera responsable.
                        </p>
                        <p>
                            Los precios, disponibilidad, sabores, tamaños y tiempos de entrega pueden variar según inventario, agenda de preparación y cobertura de domicilio.
                        </p>
                        <p>
                            Para completar un pedido, el usuario debe iniciar sesión, seleccionar productos, indicar la información de entrega y confirmar el pago por los medios disponibles.
                        </p>
                        <p>
                            Kondorito podrá; actualizar el estado del pedido desde el panel administrativo, incluyendo estados como pagado, en preparación, en camino o entregado.
                        </p>
                    </div>
                </article>

                <article id="privacidad" class="legal-section rounded-3xl bg-white p-6 sm:p-8 shadow-xl">
                    <h3 class="font-display text-3xl font-bold text-pastel-brown">Política de privacidad</h3>
                    <div class="mt-5 space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            La plataforma puede recopilar datos como nombre, correo, teléfono, ciudad, dirección de entrega, historial de pedidos e información necesaria para procesar compras.
                        </p>
                        <p>
                            Estos datos se usan para gestionar cuentas, registrar pedidos, coordinar entregas, mostrar el historial del cliente y permitir el seguimiento del pedido en tiempo real.
                        </p>
                        <p>
                            La información de pagos es procesada mediante Stripe. 
                            Kondorito no almacena directamente los datos completos de tarjetas débito o crédito.
                        </p>
                        <p>
                            El sistema de tracking usa ubicaciones para mostrar el avance del domiciliario y el destino del pedido.
                        </p>
                    </div>
                </article>

                <article id="cookies" class="legal-section rounded-3xl bg-white p-6 sm:p-8 shadow-xl">
                    <h3 class="font-display text-3xl font-bold text-pastel-brown">Pol&iacute;tica de cookies y almacenamiento local</h3>
                    <div class="mt-5 space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            La web puede usar sesión del navegador y almacenamiento local para mantener activa la cuenta, conservar el carrito del usuario y mejorar la experiencia de compra.
                        </p>
                        <p>
                            El carrito se guarda de forma asociada al usuario que inició sesión, para evitar que los productos se pierdan al cambiar de página.
                        </p>
                        <p>
                            El usuario puede cerrar sesión o limpiar los datos del navegador si desea eliminar información almacenada localmente.
                        </p>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm text-gray-200">
                &copy; <?php echo date('Y'); ?> Kondorito Postres y Pasteles. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <?php include 'cart_modal.php'; ?>
    <script>
        function ajustarVistaLegal() {
            const hash = window.location.hash || '#terminos';
            const hero = document.getElementById('legal-hero');

            if (hash === '#terminos') {
                hero.classList.remove('hidden');
                window.scrollTo({ top: 0, behavior: 'instant' });
                return;
            }

            hero.classList.add('hidden');

            const target = document.querySelector(hash);
            if (target) {
                setTimeout(() => {
                    target.scrollIntoView({ behavior: 'instant', block: 'start' });
                }, 0);
            }
        }

        window.addEventListener('load', ajustarVistaLegal);
        window.addEventListener('hashchange', ajustarVistaLegal);
    </script>
</body>
</html>
