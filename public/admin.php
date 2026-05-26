<?php


require_once __DIR__ . '/../conexion.php';

date_default_timezone_set('America/Bogota');
$fechaSeleccionada = date('Y-m-d');

if(isset($_GET['fecha']) && !empty($_GET['fecha'])){

    $fechaSeleccionada = $_GET['fecha'];

}


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
ON pedidos.id = detalle_pedidos.pedido_id

WHERE DATE(pedidos.creado_en) = :fecha

ORDER BY pedidos.id DESC
";


$stmt = $pdo->prepare($query);

$stmt->execute([
    'fecha' => $fechaSeleccionada
]);


$totalVentas = 0;
$pedidosArray = [];

while($pedido = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $pedidoId = $pedido['id'];
    if (!isset($pedidosArray[$pedidoId])) {

    
        
    $totalVentas += $pedido['total'];

        $pedidosArray[$pedidoId] = [
            'info' => [
                'id' => $pedido['id'],
                'nombre_usuario' => $pedido['nombre_usuario'],
                'direccion' => $pedido['direccion'],
                'lugar_entrega' => $pedido['lugar_entrega'] ?? '',
                'indicaciones_entrega' => $pedido['indicaciones_entrega'] ?? '',
                'telefono' => $pedido['telefono'],
                'ciudad' => $pedido['ciudad'],
                'metodo_pago' => $pedido['metodo_pago'],
                'domiciliario_id' => $pedido['domiciliario_id'],
                'estado_tracking' => $pedido['estado_tracking'],
                'total' => $pedido['total']
            ],
            'productos' => []
        ];
    }

    $pedidosArray[$pedidoId]['productos'][] = [
        'nombre_producto' => $pedido['nombre_producto'],
        'descripcion_producto' => $pedido['descripcion_producto'],
        'categoria' => $pedido['categoria'],
        'relleno' => $pedido['relleno'],
        'descripcion_adicional' => $pedido['descripcion_adicional'],
        'cantidad' => $pedido['cantidad']
    ];
}
$totalPedidos = count($pedidosArray);

$queryInventario = "
SELECT *
FROM inventario
ORDER BY id DESC
";

$inventario = $pdo->query($queryInventario);

$stmtDomiciliarios = $pdo->query("
    SELECT id, nombre, telefono, estado
    FROM domiciliarios
    ORDER BY nombre ASC
");

$domiciliarios = $stmtDomiciliarios->fetchAll();

$mensajeOk = $_GET['ok'] ?? '';
$mensajeError = $_GET['error'] ?? '';

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
                    AdministraciÃ³n
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

                    Panel administrativo ðŸ°

                </h1>

                <p class="text-gray-500 text-lg">

                    Control total de pedidos e inventario.

                </p>

            </div>

        </div>
        
        <!-- FILTRO POR FECHA -->
    <form method="GET" class="mb-6 flex gap-3 items-center">

        <input
            type="date"
            name="fecha"
            value="<?php echo $fechaSeleccionada; ?>"
            class="border px-4 py-2 rounded-xl">

        <button
            class="bg-orange-500 text-white px-4 py-2 rounded-xl">

            Filtrar

        </button>

    </form>


    <!-- Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-14 max-w-4xl mx-auto">

    <!-- Pedidos -->
    <div class="bg-white rounded-[30px] shadow-xl p-8 text-center">

        <p class="text-gray-500 mb-3">

            Pedidos Hoy

        </p>

        <h2 class="text-5xl font-bold text-amber-900">

           <?= $totalPedidos ?>

        </h2>

    </div>

    <!-- Ventas -->
    <div class="bg-white rounded-[30px] shadow-xl p-8 text-center">

        <p class="text-gray-500 mb-3">

            Ventas Hoy

        </p>

        <h2 class="text-5xl font-bold text-green-600">

            $<?= number_format($totalVentas) ?>

        </h2>

    </div>

</div>


<?php if ($mensajeOk !== ''): ?>
    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 font-semibold">
        <?= htmlspecialchars($mensajeOk, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if ($mensajeError !== ''): ?>
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 font-semibold">
        <?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>



        <!-- PEDIDOS -->
        <section id="pedidos" class="mb-16">

            <div class="flex justify-between items-center mb-8">

                <h2 class="text-4xl font-bold text-amber-900">

                    Pedidos recientes

                </h2>

            </div>


            <div class="columns-1 lg:columns-2 gap-8 space-y-8">

<?php foreach($pedidosArray as $pedidoData): ?>

<?php
    $pedido = $pedidoData['info'];
    $productos = $pedidoData['productos'];
?>


<div class="bg-white rounded-[35px] overflow-hidden shadow-2xl border border-orange-50 break-inside-avoid mb-8">

    <div class="bg-gradient-to-r from-amber-700 via-orange-400 to-orange-300 p-7 text-white">

        <div class="flex items-center justify-between">

            <div>

                <p class="uppercase tracking-widest text-sm opacity-80 mb-2">
                    Pedido
                </p>

                <h2 class="text-4xl font-extrabold">
                    #<?= $pedido['id'] ?>
                </h2>
    
                <form action="actualizar_tracking.php" method="POST" class="mt-4 flex gap-3 items-center">

    <input 
        type="hidden"
        name="id"
        value="<?php echo $pedido['id']; ?>">
     
        <input 
        type="hidden"
        name="fecha"
        value="<?php echo $fechaSeleccionada; ?>">

    <select
    name="estado_tracking"
    class="bg-white text-black border border-gray-300 rounded-xl px-4 py-2 w-52">

    <option value="sin_asignar"
        <?php if($pedido['estado_tracking'] == 'sin_asignar') echo 'selected'; ?>>

        Sin asignar

    </option>

    <option value="en_preparacion"
        <?php if($pedido['estado_tracking'] == 'en_preparacion') echo 'selected'; ?>>

        En preparaciÃ³n

    </option>

    <option value="en_camino"
        <?php if($pedido['estado_tracking'] == 'en_camino') echo 'selected'; ?>>

        En camino

    </option>

    <option value="entregado"
        <?php if($pedido['estado_tracking'] == 'entregado') echo 'selected'; ?>>

        Entregado

    </option>

    <option value="cancelado"
        <?php if($pedido['estado_tracking'] == 'cancelado') echo 'selected'; ?>>

        Cancelado

    </option>

</select>

    <button
        class="bg-green-500 text-white px-4 py-2 rounded-xl">

        Actualizar

    </button>

</form>

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
                ðŸ‘¤
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
                    Direccion principal
                </p>

                <p class="font-bold text-gray-800 leading-relaxed">
                    <?= $pedido['direccion'] ?>
                </p>

            </div>

            <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100">

                <p class="text-sm text-gray-500 mb-2">
                    Conjunto o lugar
                </p>

                <p class="font-bold text-gray-800 leading-relaxed">
                    <?= htmlspecialchars($pedido['lugar_entrega'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </p>

            </div>

            <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100">

                <p class="text-sm text-gray-500 mb-2">
                    TelÃ©fono
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
                    MÃ©todo de pago
                </p>

                <p class="font-bold text-gray-800">
                    <?= $pedido['metodo_pago'] ?>
                </p>

            </div>

            <?php if (!empty($pedido['indicaciones_entrega'])): ?>
                <div class="bg-orange-50 rounded-3xl p-5 border border-orange-100 md:col-span-2">

                    <p class="text-sm text-gray-500 mb-2">
                        Indicaciones de entrega
                    </p>

                    <p class="font-bold text-gray-800 leading-relaxed">
                        <?= htmlspecialchars($pedido['indicaciones_entrega'], ENT_QUOTES, 'UTF-8') ?>
                    </p>

                </div>
            <?php endif; ?>

        </div>  

        <?php foreach($productos as $producto): ?>

<div class="bg-[#F7F3E8] rounded-[30px] p-8 border border-yellow-100 mb-8">

    <div class="flex justify-between items-center mb-8">

        <h3 class="text-4xl font-extrabold text-amber-900">
            Producto
        </h3>

        <div class="bg-yellow-200 text-amber-800 font-bold px-5 py-2 rounded-2xl shadow">
            x<?= $producto['cantidad'] ?>
        </div>

    </div>

    <h2 class="text-5xl font-extrabold text-slate-900 mb-5">
        <?= $producto['nombre_producto'] ?>
    </h2>

    <p class="text-gray-600 text-lg mb-8">
        <?= $producto['descripcion_producto'] ?>
    </p>

    <div class="grid md:grid-cols-2 gap-6">

        <div class="bg-white rounded-[25px] p-6 shadow-sm">

            <p class="text-gray-500 mb-2">
                CategorÃ­a
            </p>

            <h4 class="text-2xl font-bold text-amber-900">
                <?= $producto['categoria'] ?>
            </h4>

        </div>

        <div class="bg-white rounded-[25px] p-6 shadow-sm">

            <p class="text-gray-500 mb-2">
                Relleno
            </p>

            <h4 class="text-2xl font-bold text-amber-900">
                <?= $producto['relleno'] ?>
            </h4>

        </div>

    </div>

    <?php if(!empty($producto['descripcion_adicional'])): ?>

        <div class="mt-8 bg-white rounded-[25px] p-6 shadow-sm">

            <p class="text-gray-500 mb-3">
                DescripciÃ³n adicional
            </p>

            <p class="text-lg text-gray-700">
                <?= $producto['descripcion_adicional'] ?>
            </p>

        </div>

    <?php endif; ?>

</div>

<?php endforeach; ?>


        <div class="bg-blue-50 border border-orange-100 rounded-3xl p-6">

                    <h3 class="text-xl font-bold text-orange-900 mb-4">
                        Asignar domiciliario
                    </h3>

                    <?php if (!empty($pedido['domiciliario_id'])): ?>
                        <p class="mb-4 text-sm font-semibold text-orange-700">
                            Domiciliario asignado: #<?= htmlspecialchars((string) $pedido['domiciliario_id'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    <?php endif; ?>

                    <form action="asignar_domiciliario.php" method="POST" class="space-y-4">
                        <input type="hidden" name="pedido_id" value="<?= htmlspecialchars((string) $pedido['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="fecha" value="<?= htmlspecialchars($fechaSeleccionada, ENT_QUOTES, 'UTF-8') ?>">

                        <select
                            name="domiciliario_id"
                            required
                            class="w-full bg-white border border-orange-200 rounded-2xl px-4 py-3 font-semibold text-orange-900 outline-none focus:ring-4 focus:ring-orange-100">
                            <option value="">Seleccionar domiciliario</option>

                            <?php foreach ($domiciliarios as $domiciliario): ?>
                                <option value="<?= htmlspecialchars((string) $domiciliario['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($domiciliario['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                    - <?= htmlspecialchars($domiciliario['estado'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button
                            type="submit"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold px-5 py-3 rounded-2xl shadow-lg transition">
                            Asignar y enviar a PWA
                        </button>
                    </form>

                </div>

  </div>

</div>


<?php endforeach; ?>


            </div>

        </section>

    </main>

</body>

</html>

