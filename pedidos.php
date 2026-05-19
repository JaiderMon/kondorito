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

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pedidos</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body class="bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50 min-h-screen p-8">

<div class="flex">

    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-2xl min-h-screen p-8">

        <div class="flex items-center gap-4 mb-14">

            <div class="w-14 h-14 rounded-full bg-yellow-200 flex items-center justify-center">

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
            class="flex items-center gap-4 hover:bg-orange-50 p-4 rounded-2xl transition">

                <i class="fas fa-chart-line text-orange-500"></i>

                Panel administrativo

            </a>


            <a href="pedidos.php"
            class="flex items-center gap-4  bg-orange-100 p-4 rounded-2xl font-bold text-amber-900">

                <i class="fas fa-receipt text-pink-500"></i>

                Pedidos

            </a>


            <a href="inventario.php"
            class="flex items-center gap-4 hover:bg-orange-50 p-4 rounded-2xl" >

                <i class="fas fa-box-open text-orange-500"></i>

                Inventario

            </a>

        </nav>

    </aside>

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-10">

        <div>
            <h1 class="text-5xl font-extrabold text-amber-900">
                Panel de Pedidos
            </h1>

            <p class="text-amber-700 mt-2 text-lg">
                Administración de pedidos Kondorito
            </p>
        </div>

        <div class="bg-white px-6 py-4 rounded-3xl shadow-lg border border-orange-100">
            <p class="text-sm text-gray-500">Pedidos registrados</p>
            <h2 class="text-3xl font-bold text-amber-900">
                <?= pg_num_rows($result) ?>
            </h2>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <?php while($pedido = pg_fetch_assoc($result)): ?>

        <div class="bg-white rounded-[30px] shadow-xl overflow-hidden border border-orange-100 hover:scale-[1.01] transition-all duration-300">

            <div class="bg-gradient-to-r from-amber-700 to-orange-500 p-6 text-white">

                <div class="flex justify-between items-center">

                    <div>
                        <h2 class="text-3xl font-bold">
                            Pedido #<?= $pedido['id'] ?>
                        </h2>

                        <p class="opacity-90 mt-1">
                            <?= $pedido['nombre_usuario'] ?>
                        </p>
                    </div>

                    <div class="bg-white/20 px-4 py-2 rounded-2xl backdrop-blur-sm">
                        <p class="text-sm">Total</p>
                        <h3 class="text-2xl font-bold">
                            $<?= number_format($pedido['total']) ?>
                        </h3>
                    </div>

                </div>

            </div>

            <div class="p-7">

                <div class="grid grid-cols-2 gap-5 mb-7">

                    <div class="bg-orange-50 rounded-2xl p-4">
                        <p class="text-sm text-gray-500 mb-1">
                            Dirección
                        </p>

                        <p class="font-semibold text-gray-800">
                            <?= $pedido['direccion'] ?>
                        </p>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-4">
                        <p class="text-sm text-gray-500 mb-1">
                            Teléfono
                        </p>

                        <p class="font-semibold text-gray-800">
                            <?= $pedido['telefono'] ?>
                        </p>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-4">
                        <p class="text-sm text-gray-500 mb-1">
                            Ciudad
                        </p>

                        <p class="font-semibold text-gray-800">
                            <?= $pedido['ciudad'] ?>
                        </p>
                    </div>

                    <div class="bg-orange-50 rounded-2xl p-4">
                        <p class="text-sm text-gray-500 mb-1">
                            Método de pago
                        </p>

                        <p class="font-semibold text-gray-800">
                            <?= $pedido['metodo_pago'] ?>
                        </p>
                    </div>

                </div>

                <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6 mb-6">

                    <div class="flex items-center justify-between mb-5">

                        <h3 class="text-2xl font-bold text-amber-900">
                            Producto
                        </h3>

                        <span class="bg-amber-200 text-amber-900 px-4 py-2 rounded-xl text-sm font-bold">
                            x<?= $pedido['cantidad'] ?>
                        </span>

                    </div>

                    <h4 class="text-2xl font-bold text-gray-800 mb-3">
                        <?= $pedido['nombre_producto'] ?>
                    </h4>

                    <p class="text-gray-600 mb-5 leading-relaxed">
                        <?= $pedido['descripcion_producto'] ?>
                    </p>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="bg-white rounded-2xl p-4">
                            <p class="text-sm text-gray-500 mb-1">
                                Categoría
                            </p>

                            <p class="font-bold text-amber-900">
                                <?= $pedido['categoria'] ?>
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl p-4">
                            <p class="text-sm text-gray-500 mb-1">
                                Relleno
                            </p>

                            <p class="font-bold text-amber-900">
                                <?= $pedido['relleno'] ?>
                            </p>
                        </div>

                    </div>

                    <?php if(!empty($pedido['descripcion_adicional'])): ?>

                    <div class="mt-5 bg-white rounded-2xl p-4 border border-dashed border-orange-300">

                        <p class="text-sm text-gray-500 mb-2">
                            Descripción adicional
                        </p>

                        <p class="text-gray-700 leading-relaxed">
                            <?= $pedido['descripcion_adicional'] ?>
                        </p>

                    </div>

                    <?php endif; ?>

                </div>

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-gray-500 mb-2">
                            Estado del pedido
                        </p>

                        <select class="bg-orange-50 border border-orange-200 rounded-2xl px-5 py-3 font-semibold text-amber-900 outline-none focus:ring-4 focus:ring-orange-200">

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

                    <button class="bg-gradient-to-r from-amber-700 to-orange-500 hover:opacity-90 text-white font-bold px-6 py-3 rounded-2xl shadow-lg transition-all">
                        Guardar
                    </button>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

    </div>

</div>

</body>

</html>