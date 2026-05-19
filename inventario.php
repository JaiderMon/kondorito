<?php

require 'conexionpedidos.php';

$fechaSeleccionada = date('Y-m-d');

if(isset($_GET['fecha']) && !empty($_GET['fecha'])){

    $fechaSeleccionada = $_GET['fecha'];

}
$verificar = "
SELECT *
FROM inventario
WHERE fecha = '$fechaSeleccionada'
LIMIT 1
";

$resultVerificar = pg_query($conn, $verificar);

if(pg_num_rows($resultVerificar) == 0){

    $copiar = "
    INSERT INTO inventario (
        producto,
        sabor,
        tamano,
        cantidad,
        fecha
    )

    SELECT
        producto,
        sabor,
        tamano,
        cantidad,
        '$fechaSeleccionada'

    FROM inventario

    WHERE fecha = (
        SELECT MAX(fecha)
        FROM inventario
        WHERE fecha < '$fechaSeleccionada'
    )
    ";

    pg_query($conn, $copiar);
}

$query = "
SELECT *
FROM inventario
WHERE fecha = '$fechaSeleccionada'
ORDER BY id DESC
";

$inventario = pg_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Inventario</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

</head>

<body class="bg-gradient-to-br from-orange-50 via-pink-50 to-yellow-50 min-h-screen">

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
            class="flex items-center gap-4 hover:bg-orange-50 p-4 rounded-2xl transition">

                <i class="fas fa-receipt text-pink-500"></i>

                Pedidos

            </a>


            <a href="inventario.php"
            class="flex items-center gap-4 bg-orange-100 p-4 rounded-2xl font-bold text-amber-900">

                <i class="fas fa-box-open text-orange-500"></i>

                Inventario

            </a>

        </nav>

    </aside>


    <!-- Main -->
    <main class="flex-1 p-10">

        <div class="flex justify-between items-center mb-12">

            <div>

                <h1 class="text-5xl font-bold text-amber-900 mb-3">

                    Inventario Diario 🍰

                </h1>

                <p class="text-gray-500 text-lg">

                    Gestiona productos y producción diaria.

                </p>

            </div>


            <button
            onclick="document.getElementById('modal').classList.remove('hidden')"
            class="bg-amber-900 hover:bg-orange-500 text-white px-8 py-4 rounded-2xl font-bold transition shadow-xl">

                + Nuevo producto

            </button>

        </div>
        <form method="GET" class="mb-8 flex items-center gap-4">

       <form action="inventario.php" method="GET" class="mb-8 flex items-center gap-4">

    <input
    type="date"
    name="fecha"
    value="<?= $fechaSeleccionada ?>"
    class="border border-orange-200 rounded-2xl px-5 py-3">

    <button
    type="submit"
    class="bg-amber-700 hover:bg-amber-600 text-white px-6 py-3 rounded-2xl font-bold transition">

        Ver día

    </button>

</form>



        <!-- Tabla -->
        <div class="bg-white rounded-[35px] shadow-2xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-orange-100">

                        <tr>
                            

                            <th class="text-centerp-6">
                                Producto
                            </th>

                            <th class="text-center p-6">
                                Sabor
                            </th>

                            <th class="text-center p-6">
                                Tamaño
                            </th>

                            <th class="text-center p-6">
                                Cantidad
                            </th>

                            <th class="text-center p-6">
                                Hacer mañana
                            </th>

                            <th class="text-center p-6">
                                Guardar
                            </th>
                             <th class="text-center p-6">
                                Eliminar
                            </th>
                            

                        </tr>

                    </thead>


                    <tbody>

                    <?php while($item = pg_fetch_assoc($inventario)): ?>

                    <tr class="border-b hover:bg-orange-50 transition">
                    
                 

<form action="guardar_inventario.php"
method="POST">

    <td class="p-6 font-semibold text-amber-900 text-center">

        <?= $item['producto'] ?>

    </td>

    <td class="p-6 text-center">

        <?= $item['sabor'] ?>

    </td>

    <td class="p-6 text-center">

        <?= $item['tamano'] ?>

    </td>

    <td class="p-6 text-center" >

        <input
        type="hidden"
        name="id"
        value="<?= $item['id'] ?>">

        <input
        type="hidden"
        name="fecha"
        value="<?= $item['fecha'] ?>">

        <input
        type="number"
        name="cantidad"
        value="<?= $item['cantidad'] ?>"
        class="border-2 border-orange-200 rounded-2xl px-5 py-3 w-28 focus:outline-none focus:border-orange-500">

    </td>

    <td class="p-6 font-bold text-red-500 text-xl text-center">

        <?= 7 - $item['cantidad'] ?>

    </td>

    <td class="p-6 text-center">

        <button
        class="bg-amber-900 hover:bg-orange-500 text-white px-6 py-3 rounded-2xl transition font-semibold shadow-lg">

            Guardar

        </button>

    </td>

</form>
                        <td class="p-5 text-center">

                         <a href="eliminar_producto.php?id=<?= $item['id'] ?>"
                         class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl">

                            Eliminar

                         </a>

                       </td>
                      

                        </form>

                    </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>



<!-- Modal -->
<div id="modal"
class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white rounded-[35px] p-10 w-full max-w-2xl shadow-2xl">

        <div class="flex justify-between items-center mb-8">

            <h2 class="text-4xl font-bold text-amber-900">

                Nuevo producto

            </h2>


            <button
            onclick="document.getElementById('modal').classList.add('hidden')"
            class="text-3xl text-gray-500 hover:text-black">

                &times;

            </button>

        </div>


        <form action="nuevo_producto.php"
        method="POST"
        class="space-y-6">

            <input
            type="text"
            name="producto"
            placeholder="Producto"
            class="w-full border-2 border-orange-200 rounded-2xl px-6 py-4">


            <input
            type="text"
            name="sabor"
            placeholder="Sabor"
            class="w-full border-2 border-orange-200 rounded-2xl px-6 py-4">


            <input
            type="text"
            name="tamano"
            placeholder="Tamaño"
            class="w-full border-2 border-orange-200 rounded-2xl px-6 py-4">


            <input
            type="number"
            name="cantidad"
            placeholder="Cantidad"
            class="w-full border-2 border-orange-200 rounded-2xl px-6 py-4">


            <button
            class="w-full bg-amber-900 hover:bg-orange-500 text-white py-5 rounded-2xl font-bold text-lg transition">

                Guardar producto

            </button>

        </form>

    </div>

</div>

</body>

</html>