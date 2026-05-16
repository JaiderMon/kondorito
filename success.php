<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Pago exitoso</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    window.cartUserKey = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : 'null'; ?>;
    </script>
    <script src="assets/js/cart.js" defer></script>


</head>

<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const statusElement = document.getElementById('order-status');
        const cart = window.Cart ? Cart.getItems() : [];

        if (cart.length === 0) {
            statusElement.textContent = 'No encontramos productos pendientes por registrar.';
            return;
        }

        try {
            const response = await fetch('crear_pedido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(cart)
            });

            const data = await response.json();

            if (!response.ok || !data.ok) {
                statusElement.textContent = data.error || 'No se pudo registrar el pedido.';
                return;
            }

            localStorage.removeItem(`cart:${window.cartUserKey}`);
            localStorage.removeItem('cart:guest');

            statusElement.textContent = `Tu pedido #${data.pedido_id} fue registrado correctamente.`;
        } catch (error) {
            statusElement.textContent = 'Ocurrió un error al registrar el pedido.';
        }
    });
</script>


<body class="bg-green-50 min-h-screen flex items-center justify-center px-4 py-8">

    <div class="bg-white shadow-2xl rounded-3xl p-6 sm:p-12 text-center w-full max-w-lg">

        <h1 class="text-3xl sm:text-5xl font-bold text-green-600 mb-6">
            ✅ Pago exitoso
        </h1>

        <p class="text-gray-600 text-lg mb-8">
            Gracias por tu compra en Kondorito 🍰
        </p>

        <p id="order-status" class="text-sm text-gray-500 mb-6">
            Registrando tu pedido...
        </p>


        <a href="index.php"
        class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 sm:px-8 py-4 rounded-full font-bold">

            Volver al inicio

        </a>

    </div>

</body>

</html>
