<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once __DIR__ . '/../conexion.php';

if (!isset($_SESSION['usuario'], $_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function estadoPedidoTexto($estado_tracking) {

    $estados = [

        'pagado' => [
            'texto' => 'Pagado',
            'color' => 'bg-blue-100 text-blue-700',
            'icono' => '💳'
        ],

        'en_preparacion' => [
            'texto' => 'En preparación',
            'color' => 'bg-yellow-100 text-yellow-700',
            'icono' => '🍰'
        ],

        'en_camino' => [
            'texto' => 'En camino',
            'color' => 'bg-orange-100 text-orange-700',
            'icono' => '🛵'
        ],

        'entregado' => [
            'texto' => 'Entregado',
            'color' => 'bg-green-100 text-green-700',
            'icono' => '✅'
        ],

        'cancelado' => [
            'texto' => 'Cancelado',
            'color' => 'bg-red-100 text-red-700',
            'icono' => '❌'
        ]

    ];

    $data = $estados[$estado_tracking] ?? [
        'texto' => ucfirst((string)$estado_tracking),
        'color' => 'bg-gray-100 text-gray-700',
        'icono' => '📦'
    ];

    return '

    <div class=\"inline-flex items-center gap-2 px-4 py-2 rounded-full font-semibold ' . $data['color'] . '\">

        <span>' . $data['icono'] . '</span>

        <span>' . $data['texto'] . '</span>

    </div>

    ';
}

function estadoPedidoClase($estado_tracking) {
    $clases = [
        'pagado' => 'bg-green-100 text-green-700',
        'en_preparacion' => 'bg-yellow-100 text-yellow-700',
        'en_camino' => 'bg-blue-100 text-blue-700',
        'entregado' => 'bg-gray-100 text-gray-600',
        'cancelado' => 'bg-red-100 text-red-600'
    ];

    return $clases[$estado_tracking] ?? 'bg-gray-100 text-gray-600';
}

$correo = $_SESSION['correo'];
$trackingUrl = rtrim(getenv('TRACKING_SERVER_URL') ?: 'http://localhost:3000', '/');
$pasteleriaLat = (float) (getenv('PASTELERIA_LAT') ?: 7.077154857097324);
$pasteleriaLng = (float) (getenv('PASTELERIA_LNG') ?: -73.08790648174613);

$stmtPedidos = $pdo->prepare(
    "SELECT id, total, estado_tracking, ciudad, direccion, lugar_entrega,
            domiciliario_id, lat_entrega, lng_entrega, creado_en
     FROM pedidos
     WHERE correo_usuario = :correo
     ORDER BY creado_en DESC"
);

$stmtPedidos->execute([
    'correo' => $correo
]);

$pedidos = $stmtPedidos->fetchAll();

$detallesPorPedido = [];

if (count($pedidos) > 0) {
    $pedidoIds = array_column($pedidos, 'id');
    $placeholders = implode(',', array_fill(0, count($pedidoIds), '?'));

    $stmtDetalles = $pdo->prepare(
        "SELECT pedido_id, nombre_producto, descripcion_producto, tamano, relleno,
                descripcion_adicional, precio_unitario, cantidad, subtotal
         FROM detalle_pedidos
         WHERE pedido_id IN ($placeholders)
         ORDER BY id ASC"
    );

    $stmtDetalles->execute($pedidoIds);

    foreach ($stmtDetalles->fetchAll() as $detalle) {
        $detallesPorPedido[$detalle['pedido_id']][] = $detalle;
    }
}

$estadosHistorial = ['entregado', 'cancelado'];

$pedidosEnCurso = array_values(array_filter($pedidos, function ($pedido) use ($estadosHistorial) {
    return !in_array($pedido['estado_tracking'], $estadosHistorial, true);
}));

$pedidosHistorial = array_values(array_filter($pedidos, function ($pedido) use ($estadosHistorial) {
    return in_array($pedido['estado_tracking'], $estadosHistorial, true);
}));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis pedidos - Kondorito</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
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
    <style>
        .client-tracking-map {
            position: relative;
            z-index: 0;
        }

        .client-tracking-map .leaflet-pane,
        .client-tracking-map .leaflet-control {
            z-index: 1;
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
                    <details class="relative">
                        <summary class="flex cursor-pointer list-none items-center text-gray-700 hover:text-primary">
                            <i class="fas fa-user text-lg"></i>
                            <span class="ml-1 sm:hidden">Cuenta</span>
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
                            <?php echo count($pedidosEnCurso); ?>
                        </span>
                    </div>

                    <?php if (count($pedidosEnCurso) === 0): ?>
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
                    <?php else: ?>
                        <div class="space-y-5">
                            <?php foreach ($pedidosEnCurso as $pedido): ?>
                                <?php $detalles = $detallesPorPedido[$pedido['id']] ?? []; ?>

                                <article class="rounded-3xl border border-pink-100 bg-pink-50/40 p-5">
                                    <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <h4 class="text-xl font-bold text-pastel-brown">
                                                Pedido #<?php echo e($pedido['id']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                <?php echo e(date('d/m/Y h:i A', strtotime($pedido['creado_en']))); ?>
                                            </p>
                                        </div>

                                        <span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo estadoPedidoClase($pedido['estado_tracking']); ?>">
                                           <?php echo estadoPedidoTexto($pedido['estado_tracking']); ?>
                                        </span>
                                    </div>

                                    <div class="space-y-3">
                                        <?php foreach ($detalles as $detalle): ?>
                                            <div class="rounded-2xl bg-white p-4 shadow-sm">
                                                <div class="flex justify-between gap-4">
                                                    <div>
                                                        <p class="font-semibold text-gray-800">
                                                            <?php echo e($detalle['nombre_producto']); ?> x<?php echo e($detalle['cantidad']); ?>
                                                        </p>

                                                        <?php if (!empty($detalle['tamano']) || !empty($detalle['relleno'])): ?>
                                                            <p class="mt-1 text-xs text-gray-500">
                                                                Tama&ntilde;o: <?php echo e($detalle['tamano'] ?: 'Normal'); ?> |
                                                                Relleno: <?php echo e($detalle['relleno'] ?: 'Ninguno'); ?>
                                                            </p>
                                                        <?php endif; ?>

                                                        <?php if (!empty($detalle['descripcion_adicional'])): ?>
                                                            <p class="mt-2 rounded-xl bg-amber-50 px-3 py-2 text-xs text-amber-900">
                                                                Nota: <?php echo e($detalle['descripcion_adicional']); ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>

                                                    <span class="font-bold text-primary">
                                                        $<?php echo number_format((float) $detalle['subtotal'], 2); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php
                                        $direccionEntrega = trim(($pedido['direccion'] ?? '') . ', ' . ($pedido['lugar_entrega'] ?? ''));
                                        $tieneTracking = !empty($pedido['domiciliario_id'])
                                            && $pedido['lat_entrega'] !== null
                                            && $pedido['lng_entrega'] !== null
                                            && in_array($pedido['estado_tracking'], ['asignado', 'en_camino'], true);
                                    ?>

                                    <div class="mt-5 border-t border-pink-100 pt-4">
                                        <div class="flex flex-wrap justify-between gap-3 text-sm">
                                            <span class="text-gray-500">
                                                Entrega: <?php echo e($direccionEntrega !== ',' ? $direccionEntrega : 'Sin direcci&oacute;n'); ?>, <?php echo e($pedido['ciudad'] ?: 'Sin ciudad'); ?>
                                            </span>
                                            <span class="text-lg font-bold text-pastel-brown">
                                                Total: $<?php echo number_format((float) $pedido['total'], 2); ?>
                                            </span>
                                        </div>

                                        <?php if ($tieneTracking): ?>
                                            <div
                                                class="client-tracking-map mt-5 h-72 w-full overflow-hidden rounded-3xl border border-pink-100 bg-white shadow-sm"
                                                data-client-tracking-map
                                                data-pedido-id="<?php echo e($pedido['id']); ?>"
                                                data-domiciliario-id="<?php echo e($pedido['domiciliario_id']); ?>"
                                                data-destino-lat="<?php echo e($pedido['lat_entrega']); ?>"
                                                data-destino-lng="<?php echo e($pedido['lng_entrega']); ?>"
                                                data-destino-texto="<?php echo e(trim($direccionEntrega . ', ' . ($pedido['ciudad'] ?? ''))); ?>"
                                            ></div>
                                            <p class="mt-3 text-xs text-gray-500">
                                                Sigue en tiempo real la ubicaci&oacute;n del domiciliario asignado a este pedido.
                                            </p>
                                        <?php elseif (!empty($pedido['domiciliario_id'])): ?>
                                            <p class="mt-4 rounded-2xl bg-white px-4 py-3 text-sm text-gray-500">
                                                El mapa se activar&aacute; cuando el pedido tenga ubicaci&oacute;n de entrega disponible.
                                            </p>
                                        <?php else: ?>
                                            <p class="mt-4 rounded-2xl bg-white px-4 py-3 text-sm text-gray-500">
                                                El mapa se activar&aacute; cuando la pasteler&iacute;a asigne un domiciliario.
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

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
                            <?php echo count($pedidosHistorial); ?>
                        </span>

                    </div>

                    <?php if (count($pedidosHistorial) === 0): ?>
                        <div class="rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
                            <i class="fas fa-history text-5xl text-gray-300"></i>
                            <h4 class="mt-5 text-xl font-bold text-pastel-brown">
                                A&uacute;n no tienes historial de pedidos
                            </h4>
                            <p class="mt-2 text-gray-500">
                                Tus pedidos finalizados se guardar&aacute;n en esta secci&oacute;n.
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-5">
                            <?php foreach ($pedidosHistorial as $pedido): ?>
                                <?php $detalles = $detallesPorPedido[$pedido['id']] ?? []; ?>

                                <article class="rounded-3xl border border-gray-100 bg-gray-50 p-5">
                                    <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <h4 class="text-xl font-bold text-pastel-brown">
                                                Pedido #<?php echo e($pedido['id']); ?>
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                <?php echo e(date('d/m/Y h:i A', strtotime($pedido['creado_en']))); ?>
                                            </p>
                                        </div>

                                        <span class="rounded-full px-3 py-1 text-xs font-semibold <?php echo estadoPedidoClase($pedido['estado_tracking']); ?>">
                                            <?php echo estadoPedidoTexto($pedido['estado_tracking']); ?>
                                        </span>
                                    </div>

                                    <div class="space-y-2 text-sm text-gray-600">
                                        <?php foreach ($detalles as $detalle): ?>
                                            <div class="flex justify-between gap-4">
                                                <span>
                                                    <?php echo e($detalle['nombre_producto']); ?> x<?php echo e($detalle['cantidad']); ?>
                                                </span>
                                                <span class="font-semibold">
                                                    $<?php echo number_format((float) $detalle['subtotal'], 2); ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="mt-4 border-t border-gray-200 pt-4 text-right text-lg font-bold text-pastel-brown">
                                        Total: $<?php echo number_format((float) $pedido['total'], 2); ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>

        </section>
    </main>

<?php include 'cart_modal.php'; ?>
    <script>
        const trackingUrl = <?php echo json_encode($trackingUrl); ?>;
        const pasteleria = {
            lat: <?php echo json_encode($pasteleriaLat); ?>,
            lng: <?php echo json_encode($pasteleriaLng); ?>
        };
        const trackingMaps = [];

        function createTrackingIcon(html, color) {
            return L.divIcon({
                className: '',
                html: `<div style="width:38px;height:38px;border-radius:999px;background:${color};color:white;display:grid;place-items:center;font-size:18px;border:3px solid white;box-shadow:0 8px 20px rgba(0,0,0,.2)">${html}</div>`,
                iconSize: [38, 38],
                iconAnchor: [19, 19]
            });
        }

        document.querySelectorAll('[data-client-tracking-map]').forEach((element) => {
            const destino = [
                Number(element.dataset.destinoLat),
                Number(element.dataset.destinoLng)
            ];
            const domiciliarioId = Number(element.dataset.domiciliarioId);
            const map = L.map(element, {
                scrollWheelZoom: false
            }).setView(destino, 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const bakeryMarker = L.marker([pasteleria.lat, pasteleria.lng], {
                icon: createTrackingIcon('<i class="fas fa-home"></i>', '#8b4513')
            }).addTo(map).bindPopup('Kondorito');

            const destinationMarker = L.marker(destino, {
                icon: createTrackingIcon('<i class="fas fa-map-marker-alt"></i>', '#d2691e')
            }).addTo(map).bindPopup(element.dataset.destinoTexto || 'Destino del pedido');

            const bounds = L.latLngBounds([
                [pasteleria.lat, pasteleria.lng],
                destino
            ]);

            map.fitBounds(bounds, {
                padding: [35, 35],
                maxZoom: 15
            });

            trackingMaps.push({
                map,
                domiciliarioId,
                destino,
                courierMarker: null,
                routeLine: null,
                bakeryMarker,
                destinationMarker
            });
        });

        if (trackingMaps.length > 0) {
            const socket = io(trackingUrl, {
                transports: ['websocket']
            });

            socket.on('ubicacion_domiciliario', ({ id, lat, lng }) => {
                const courierId = Number(id);
                const position = [Number(lat), Number(lng)];

                trackingMaps
                    .filter((trackingMap) => trackingMap.domiciliarioId === courierId)
                    .forEach((trackingMap) => {
                        if (!trackingMap.courierMarker) {
                            trackingMap.courierMarker = L.marker(position, {
                                icon: createTrackingIcon('<i class="fas fa-motorcycle"></i>', '#2563eb')
                            }).addTo(trackingMap.map).bindPopup('Domiciliario en camino');
                        } else {
                            trackingMap.courierMarker.setLatLng(position);
                        }

                        if (trackingMap.routeLine) {
                            trackingMap.map.removeLayer(trackingMap.routeLine);
                        }

                        trackingMap.routeLine = L.polyline([position, trackingMap.destino], {
                            color: '#2563eb',
                            weight: 4,
                            opacity: 0.85,
                            dashArray: '8 8'
                        }).addTo(trackingMap.map);
                    });
            });
        }
    </script>
</body>
</html>
