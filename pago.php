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
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gradient-to-br from-orange-50 via-pink-50 to-amber-50 min-h-screen">

    <div class="max-w-5xl mx-auto py-16 px-6">

        <!-- Título -->
        <div class="text-center mb-14">

            <h1 class="text-5xl font-bold text-amber-900 mb-4">
                Finalizar pedido 🍰
            </h1>

            <p class="text-gray-600 text-lg">
                Selecciona tu método de pago
            </p>

        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-2 gap-10">

            <!-- Resumen -->
            <div class="bg-white rounded-[35px] shadow-2xl p-10">

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

            </div>

            <!-- Métodos -->
            <div class="bg-white rounded-[35px] shadow-2xl p-10">

                <h2 class="text-3xl font-bold text-amber-900 mb-8">

                    Método de pago

                </h2>

                <div class="space-y-6">

                    <!-- Tarjeta -->
                    <button
                    class="w-full border-2 border-pink-200 hover:border-orange-400 rounded-3xl p-6 transition text-left">

                        <div class="flex items-center gap-5">

                            <i class="fas fa-credit-card text-4xl text-orange-500"></i>

                            <div>

                                <h3 class="text-xl font-bold text-amber-900">
                                    Tarjeta débito/crédito
                                </h3>

                                <p class="text-gray-500">
                                    Visa, Mastercard, Nequi, etc.
                                </p>

                            </div>

                        </div>

                    </button>

                    <!-- WhatsApp -->
                    <button
                    class="w-full border-2 border-pink-200 hover:border-green-500 rounded-3xl p-6 transition text-left">

                        <div class="flex items-center gap-5">

                            <i class="fab fa-whatsapp text-4xl text-green-500"></i>

                            <div>

                                <h3 class="text-xl font-bold text-amber-900">
                                    Confirmar por WhatsApp
                                </h3>

                                <p class="text-gray-500">
                                    Hablar directamente con la pastelería
                                </p>

                            </div>

                        </div>

                    </button>

                </div>

                <!-- Botón -->
                <button onclick="payWithStripe()"
                class="w-full mt-10 bg-amber-900 hover:bg-orange-500 text-white py-5 rounded-full text-lg font-bold transition">

                    Confirmar pedido

                </button>

            </div>

        </div>

    </div>
 <script>

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    const paymentItems = document.getElementById('payment-items');

    let total = 0;

    cart.forEach(item => {

        total += item.price * item.quantity;

        paymentItems.innerHTML += `

            <div class="flex justify-between text-lg">

                <span>
                    ${item.name} x${item.quantity}
                </span>

                <span>
                    $${(item.price * item.quantity).toFixed(2)}
                </span>

            </div>

        `;

    });

    document.getElementById('payment-total')
        .textContent = `$${total.toFixed(2)}`;
          
        async function payWithStripe() {

        const response = await fetch('stripe-checkout.php', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json'
            },

            body: JSON.stringify(cart)

        });

        const data = await response.json();

        window.location.href = data.url;

    }

</script>
</body>

</html>