<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Finalizar pedido - Kondorito</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #delivery-form input,
        #delivery-form select,
        #delivery-form textarea {
            max-width: 100%;
            min-width: 0;
            -webkit-appearance: none;
            appearance: none;
        }

        #delivery-map {
            position: relative;
            z-index: 0;
        }

        #delivery-map .leaflet-pane,
        #delivery-map .leaflet-control {
            z-index: 1;
        }
    </style>
    <script>
        window.cartUserKey = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : 'null'; ?>;
    </script>    
    <script src="assets/js/cart.js" defer></script>

</head>

<body class="bg-gradient-to-br from-orange-50 via-pink-50 to-amber-50 min-h-screen">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center flex-wrap gap-4">

            <a href="index.php" class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-birthday-cake text-2xl text-amber-900"></i>
                </div>

                <div>
                    <h1 class="text-3xl font-bold text-amber-900">
                        Kondorito
                    </h1>

                    <p class="text-sm text-gray-500">
                        Postres y Pasteles
                    </p>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-gray-700">
                <a href="index.php" class="hover:text-orange-500 transition">Inicio</a>
                <a href="Catalogocompleto.php" class="hover:text-orange-500 transition">Cat&aacute;logo</a>
                <a href="nosotros.php" class="hover:text-orange-500 transition">Nosotros</a>
                <a href="contacto.php" class="hover:text-orange-500 transition">Contacto</a>

                <?php if(isset($_SESSION['usuario'])): ?>
                    <details class="relative">
                        <summary class="flex cursor-pointer list-none items-center text-gray-700 hover:text-orange-500">
                            <i class="fas fa-user text-lg"></i>
                            <span class="ml-1">Hola, <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </summary>
                        <div class="absolute right-0 mt-3 w-56 rounded-2xl border border-pink-100 bg-white p-2 shadow-xl">
                            <a href="perfil.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
                                <i class="fas fa-user-cog"></i>
                                Configuraci&oacute;n perfil
                            </a>
                            <a href="mis_pedidos.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-500">
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
                    <a href="login.php" class="text-gray-700 hover:text-orange-500">
                        <i class="fas fa-user text-lg"></i>
                        <span class="ml-1">Mi cuenta</span>
                    </a>
                <?php endif; ?>

                <a href="#cart"
                   data-cart-button
                   class="relative bg-[#ffcce6] hover:bg-pink-300 transition-colors rounded-full p-3">
                    <i class="fas fa-shopping-cart text-xl text-[#8b4513]"></i>
                    <span data-cart-count class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>
            </nav>

            <nav class="flex w-full flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-gray-700 lg:hidden">
                <a href="index.php" class="hover:text-orange-500 transition">Inicio</a>
                <a href="Catalogocompleto.php" class="hover:text-orange-500 transition">Cat&aacute;logo</a>
                <a href="nosotros.php" class="hover:text-orange-500 transition">Nosotros</a>
                <a href="contacto.php" class="hover:text-orange-500 transition">Contacto</a>
            </nav>

        </div>
    </header>

    <div class="max-w-5xl mx-auto py-10 md:py-16 px-4 sm:px-6">

        <!-- TÃ­tulo -->
        <div class="text-center mb-14">

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-amber-900 mb-4">
                Finalizar pedido
            </h1>

            <p class="text-gray-600 text-lg">
                Selecciona tu m&eacute;todo de pago
            </p>

        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-2 gap-10">

            <!-- Resumen -->
            <div class="order-1 bg-white rounded-3xl shadow-2xl p-6 sm:p-10">

                <h2 class="text-3xl font-bold text-amber-900 mb-8">

                    Resumen del pedido

                </h2>

              <div id="payment-items" class="space-y-5"></div>

                <div class="border-t mt-8 pt-6 flex justify-between items-center">

                    <span class="text-2xl font-bold">
                        Total
                    </span>

                    <span id="payment-total"
                      class="text-3xl font-bold text-orange-500">
                      </span>

                </div>

                <div id="payment-product-gallery" class="hidden grid-cols-2 gap-4 mt-8"></div>

            </div>

            <!-- MÃ©todos -->
            <div class="order-3 md:order-2 bg-white rounded-3xl shadow-2xl p-6 sm:p-10 flex flex-col justify-center min-h-[420px]">

                <h2 class="text-3xl font-bold text-amber-900 mb-8">

                    Datos de entrega

                </h2>

                <form id="delivery-form" class="hidden space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Direcci&oacute;n principal
                        </label>
                        <input
                            type="text"
                            id="delivery-address"
                            required
                            placeholder="Ej: Cra 24#35-200"
                            class="w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Conjunto o lugar de entrega
                        </label>
                        <input
                            type="text"
                            id="delivery-place"
                            required
                            placeholder="Ej: Villa canaveral"
                            class="w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Ciudad
                            </label>
                            <select
                                id="delivery-city"
                                required
                                class="w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100">
                                <option value="">Selecciona</option>
                                <option value="Bucaramanga">Bucaramanga</option>
                                <option value="Floridablanca">Floridablanca</option>
                                <option value="Gir&oacute;n">Gir&oacute;n</option>
                                <option value="Piedecuesta">Piedecuesta</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Tel&eacute;fono
                            </label>
                            <input
                                type="tel"
                                id="delivery-phone"
                                required
                                class="w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Fecha de entrega
                            </label>
                            <input
                                type="date"
                                id="delivery-date"
                                required
                            class="block w-full max-w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Hora de entrega
                            </label>
                            <input
                                type="time"
                                id="delivery-time"
                                required
                            class="block w-full max-w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Indicaciones adicionales
                        </label>
                        <textarea
                            id="delivery-notes"
                            rows="3"
                            placeholder="Ej: llamar al llegar, torre, apartamento, porteria..."
                            class="w-full rounded-2xl border border-pink-200 px-4 py-3 outline-none focus:ring-4 focus:ring-orange-100"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Ubicacion exacta de entrega
                        </label>

                        <div class="rounded-3xl overflow-hidden border border-pink-200">
                            <div id="delivery-map" class="h-72 w-full"></div>
                        </div>

                        <p class="mt-3 text-sm text-gray-500">
                            Se recomienda ponre la dirección de entrega en el mapa.
                        </p>

                        <input type="hidden" id="delivery-lat" required>
                        <input type="hidden" id="delivery-lng" required>
                    </div>
                </form>

                <h2 class="text-3xl font-bold text-amber-900 mb-8">

                    M&eacute;todo de pago

                </h2>

                <div class="space-y-6">

                    <!-- Tarjeta -->
                    <label class="block cursor-pointer">

    <input 
        type="radio" 
        name="metodo_pago" 
        value="tarjeta"
        class="hidden peer"
    >

    <div class="w-full border-2 border-pink-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 rounded-3xl p-6 transition text-left">

        <div class="flex items-center gap-5">

            <i class="fas fa-credit-card text-4xl text-orange-500"></i>

            <div>

                <h3 class="text-xl font-bold text-amber-900">
                    Tarjeta d&eacute;bito/cr&eacute;dito
                </h3>

                <p class="text-gray-500">
                    Visa, Mastercard, Nequi, etc.
                </p>

            </div>

        </div>

    </div>

</label>

                    <!-- WhatsApp -->
                    <button
                    class="w-full border-2 border-pink-200 hover:border-green-500 rounded-3xl p-6 transition text-left">

                        <div class="flex items-center gap-5">

                            <i class="fab fa-whatsapp text-4xl text-green-500"></i>

                          <a 
                           href="https://wa.me/573155321183?text=Hola,%20quiero%20realizar%20un%20pedido%20en%20efectivo"
                        target="_blank"
                            class="block"
>

                     <div>

                    <h3 class="text-xl font-bold text-amber-900">
                      Pago en efectivo por WhatsApp
                    </h3>

                    <p class="text-gray-500">
                    Hablar directamente con la pasteler&iacute;a
                    </p>

                  </div>

               </a>

                        </div>

                    </button>

                </div>

                <!-- BotÃ³n -->
                <button onclick="payWithStripe()"
                class="w-full mt-10 bg-amber-900 hover:bg-orange-500 text-white py-5 rounded-full text-lg font-bold transition">

                    Confirmar pedido

                </button>

            </div>

            <div id="delivery-card" class="order-2 md:order-3 md:col-span-2 bg-white rounded-3xl shadow-2xl p-6 sm:p-10"></div>

        </div>

    </div>
 <script>

    let cart = [];
    const deliveryStorageKey = `kondorito_delivery:${window.cartUserKey || 'guest'}`;
    const defaultDeliveryPosition = [7.077154857097324, -73.08790648174613];
    let deliveryMap = null;
    let deliveryMarker = null;

    function setDeliveryPosition(lat, lng) {
        document.getElementById('delivery-lat').value = lat;
        document.getElementById('delivery-lng').value = lng;

        if (deliveryMarker) {
            deliveryMarker.setLatLng([lat, lng]);
        }
    }

    function initDeliveryMap(savedDelivery = {}) {
        const initialLat = Number(savedDelivery.lat_entrega) || defaultDeliveryPosition[0];
        const initialLng = Number(savedDelivery.lng_entrega) || defaultDeliveryPosition[1];

        deliveryMap = L.map('delivery-map').setView([initialLat, initialLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(deliveryMap);

        deliveryMarker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(deliveryMap);

        setDeliveryPosition(initialLat, initialLng);

        deliveryMap.on('click', (event) => {
            setDeliveryPosition(event.latlng.lat, event.latlng.lng);
        });

        deliveryMarker.on('dragend', () => {
            const position = deliveryMarker.getLatLng();
            setDeliveryPosition(position.lat, position.lng);
        });

        setTimeout(() => deliveryMap.invalidateSize(), 250);
    }

    document.addEventListener('DOMContentLoaded', function () {
        cart = Cart.getItems();

        const deliveryForm = document.getElementById('delivery-form');
        const deliveryTitle = deliveryForm.previousElementSibling;
        const deliveryCard = document.getElementById('delivery-card');

        deliveryCard.appendChild(deliveryTitle);
        deliveryCard.appendChild(deliveryForm);
        deliveryForm.classList.remove('hidden', 'mb-10');

        const paymentItems = document.getElementById('payment-items');
        const paymentTotal = document.getElementById('payment-total');
        const paymentProductGallery = document.getElementById('payment-product-gallery');

        let total = 0;

        if (cart.length === 0) {
            paymentItems.innerHTML = `
                <p class="text-gray-500">
                    No hay productos en el carrito.
                </p>
            `;
            paymentTotal.textContent = '$0.00';
            return;
        }

        paymentItems.innerHTML = cart.map(item => {
            const subtotal = Number(item.price) * Number(item.quantity);
            total += subtotal;
            const image = item.image || '';

            return `
                <div class="flex gap-4">
                    ${image ? `
                        <img
                            src="${image}"
                            alt="${item.name}"
                            class="h-20 w-20 rounded-2xl object-cover border border-orange-100 md:hidden">
                    ` : ''}
                    <div class="flex-1">
                        <div class="flex justify-between gap-4 text-lg">
                            <span>
                                ${item.name} x${item.quantity}
                            </span>
                            <span>
                                $ ${subtotal.toLocaleString('es-CO')}
                            </span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        paymentTotal.textContent = `$ ${total.toLocaleString('es-CO')}`;

        const productImages = cart
            .filter(item => item.image)
            .map(item => `
                <img
                    src="${item.image}"
                    alt="${item.name}"
                    class="h-36 w-full rounded-3xl object-cover border border-orange-100 shadow-sm">
            `)
            .join('');

        paymentProductGallery.innerHTML = productImages;

        if (productImages !== '') {
            paymentProductGallery.classList.add('md:grid');
        } else {
            paymentProductGallery.classList.remove('md:grid');
        }

        const savedDelivery = JSON.parse(localStorage.getItem(deliveryStorageKey) || '{}');

        document.getElementById('delivery-address').value = savedDelivery.direccion || '';
        document.getElementById('delivery-place').value = savedDelivery.lugar_entrega || '';
        document.getElementById('delivery-city').value = savedDelivery.ciudad || '';
        document.getElementById('delivery-phone').value = savedDelivery.telefono || '';
        document.getElementById('delivery-date').value = savedDelivery.fecha_entrega || '';
        document.getElementById('delivery-time').value = savedDelivery.hora_entrega || '';
        document.getElementById('delivery-notes').value = savedDelivery.indicaciones_entrega || '';

        initDeliveryMap(savedDelivery);
    });
          
        async function payWithStripe() {

        if (cart.length === 0) {
            alert('No hay productos en el carrito.');
            return;
        }

        const deliveryForm = document.getElementById('delivery-form');

        if (!deliveryForm.reportValidity()) {
            return;
        }

        const delivery = {
            direccion: document.getElementById('delivery-address').value.trim(),
            lugar_entrega: document.getElementById('delivery-place').value.trim(),
            ciudad: document.getElementById('delivery-city').value,
            telefono: document.getElementById('delivery-phone').value.trim(),
            fecha_entrega: document.getElementById('delivery-date').value,
            hora_entrega: document.getElementById('delivery-time').value,
            indicaciones_entrega: document.getElementById('delivery-notes').value.trim(),
            lat_entrega: document.getElementById('delivery-lat').value,
            lng_entrega: document.getElementById('delivery-lng').value
        };

        if (!delivery.lat_entrega || !delivery.lng_entrega) {
            alert('Selecciona la ubicacion exacta de entrega en el mapa.');
            return;
        }

        localStorage.setItem(deliveryStorageKey, JSON.stringify(delivery));

        const response = await fetch('stripe-checkout.php', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json'
            },

            body: JSON.stringify(cart)

        });

        const data = await response.json();

        if (!response.ok || !data.url) {
            alert(data.error || 'No se pudo iniciar el pago.');
            return;
        }

        window.location.href = data.url;

    }

</script>
<?php include 'cart_modal.php'; ?>
</body>

</html>

