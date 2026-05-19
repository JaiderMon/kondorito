<?php

require 'conexionpedidos.php';

$query = "
SELECT 
    pedidos.*,
    detalle_pedidos.nombre_producto,
    detalle_pedidos.descripcion_producto,
    detalle_pedidos.categoria,
    detalle_pedidos.relleno,
    detalle_pedidos.descripcion_adicional,
    detalle_pedidos.cantidad
FROM pedidos
INNER JOIN detalle_pedidos 
ON pedidos.id = detalle_pedidos.id
ORDER BY pedidos.id DESC
";

$result = pg_query($conn, $query);

$totalVentas = 0;
$pedidosArray = [];

while($pedido = pg_fetch_assoc($result)) {

    $totalVentas += $pedido['total'];

    $pedidosArray[] = $pedido;
}

$queryInventario = "
SELECT * FROM inventario
ORDER BY id DESC
";

$inventario = pg_query($conn, $queryInventario);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>Panel Admin - Kondorito</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body class="bg-orange-50 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-2xl min-h-screen p-8">

        <div class="flex items-center gap-4 mb-14">

            <div class="w-14 h-14 bg-yellow-200 rounded-full flex items-center justify-center">

                <i class="fas fa-birthday-cake text-2xl text-amber-900"></i>

            </div>

            <div>

                <h1 class="text-3xl font-bold text-amber-900">
                    Kondorito
                </h1>

                <p class="text-gray-500">
                    Administración
                </p>

            </div>

        </div>


        <nav class="space-y-4">

            <a href="admin.php"
            class="flex items-center gap-4 bg-orange-100 px-5 py-4 rounded-2xl text-amber-900 font-bold">

                <i class="fas fa-chart-line"></i>

                Panel administrativo

            </a>


            <a href="pedidos.php"
            class="flex items-center gap-4 hover:bg-orange-50 px-5 py-4 rounded-2xl transition">

                <i class="fas fa-receipt text-pink-500"></i>

                Pedidos

            </a>


            <a href="inventario.php"
            class="flex items-center gap-4 hover:bg-orange-50 px-5 py-4 rounded-2xl transition">

                <i class="fas fa-box-open text-orange-500"></i>

                Inventario

            </a>

        </nav>

    </aside>


    <!-- Main -->
    <main class="flex-1 p-10 overflow-y-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-12">

            <div>

                <h1 class="text-5xl font-bold text-amber-900 mb-3">

                    Panel administrativo 🍰

                </h1>

                <p class="text-gray-500 text-lg">

                    Control total de pedidos e inventario.

                </p>

            </div>

        </div>


        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-14">

            <div class="bg-white rounded-[30px] shadow-xl p-8">

                <p class="text-gray-500 mb-3">

                    Pedidos Hoy

                </p>

                <h2 class="text-5xl font-bold text-amber-900">

                    <?php echo pg_num_rows($result); ?>

                </h2>

            </div>


            <div class="bg-white rounded-[30px] shadow-xl p-8">

                <p class="text-gray-500 mb-3">

                    Producción Pendiente

                </p>

                <h2 class="text-5xl font-bold text-red-500">

                    12

                </h2>

            </div>


            <div class="bg-white rounded-[30px] shadow-xl p-8">

                <p class="text-gray-500 mb-3">

                    Ventas Hoy

                </p>

                <h2 class="text-5xl font-bold text-green-600">

                    $<?= number_format($totalVentas) ?>

                </h2>

            </div>

        </div>



        <!-- PEDIDOS -->
        <section id="pedidos" class="mb-16">

            <div class="flex justify-between items-center mb-8">

                <h2 class="text-4xl font-bold text-amber-900">

                    Pedidos recientes

                </h2>

            </div>


            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

<?php foreach($pedidosArray as $pedido): ?>

<div class="bg-white rounded-[35px] overflow-hidden shadow-2xl border border-orange-50 hover:scale-[1.01] transition-all duration-300">

    <div class="bg-gradient-to-r from-amber-700 via-orange-400 to-orange-300 p-7 text-white">

        <div class="flex items-center justify-between">

            <div>

                <p class="uppercase tracking-widest text-sm opacity-80 mb-2">
                    Pedido
                </p>

                <h2 class="text-4xl font-extrabold">
                    #<?= $pedido['id'] ?>
                </h2>

            </div>

            <div class="bg-white/20 backdrop-blur-md px-5 py-4 rounded-3xl border border-white/20">

                <p class="text-sm opacity-80">
                    Total
                </p>

                <h3 class="text-3xl font-bold">
                    $<?= number_format($pedido['total']) ?>
                </h3>

            </div>

        </div>

    </div>

    <div class="p-7">

        <div class="flex items-center gap-4 mb-8">

            <div class="w-16 h-16 rounded-full bg-orange-100 flex items-center justify-center text-2xl">
                👤
            </div>

            <div>

                <h3 class="text-2xl font-bold text-gray-800">
                    <?= $pedido['nombre_usuario'] ?>
                </h3>

                <p class="text-gray-500">
                    Cliente registrado
                </p>

            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

            <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100">

                <p class="text-sm text-gray-500 mb-2">
                    Dirección
                </p>

                <p class="font-bold text-gray-800 leading-relaxed">
                    <?= $pedido['direccion'] ?>
                </p>

            </div>

            <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100">

                <p class="text-sm text-gray-500 mb-2">
                    Teléfono
                </p>

                <p class="font-bold text-gray-800">
                    <?= $pedido['telefono'] ?>
                </p>

            </div>

            <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100">

                <p class="text-sm text-gray-500 mb-2">
                    Ciudad
                </p>

                <p class="font-bold text-gray-800">
                    <?= $pedido['ciudad'] ?>
                </p>

            </div>

            <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100">

                <p class="text-sm text-gray-500 mb-2">
                    Método de pago
                </p>

                <p class="font-bold text-gray-800">
                    <?= $pedido['metodo_pago'] ?>
                </p>

            </div>

        </div>

        <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 mb-8">

            <div class="flex justify-between items-center mb-4">

                <h4 class="text-2xl font-bold text-amber-900">
                    Estado del pedido
                </h4>

                <span class="bg-amber-200 text-amber-900 font-bold px-4 py-2 rounded-2xl">

                    <?= $pedido['estado'] ?>

                </span>

            </div>

            <select class="w-full bg-white border border-orange-200 rounded-2xl px-5 py-4 font-semibold text-amber-900 outline-none focus:ring-4 focus:ring-orange-200 transition-all">

                <option <?= $pedido['estado'] == 'Pendiente' ? 'selected' : '' ?>>
                    Pendiente
                </option>

                <option <?= $pedido['estado'] == 'Preparando' ? 'selected' : '' ?>>
                    Preparando
                </option>

                <option <?= $pedido['estado'] == 'En camino' ? 'selected' : '' ?>>
                    En camino
                </option>

                <option <?= $pedido['estado'] == 'Entregado' ? 'selected' : '' ?>>
                    Entregado
                </option>

            </select>

        </div>

        <div class="flex justify-end">

            <button class="bg-gradient-to-r from-amber-700 to-orange-500 hover:opacity-90 text-white font-bold px-8 py-4 rounded-2xl shadow-lg transition-all duration-300">

                Guardar Cambios

            </button>

        </div>

    </div>

</div>

<?php endforeach; ?>


            </div>

        </section>

    </main>

</body>

</html>