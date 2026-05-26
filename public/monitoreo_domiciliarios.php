<?php

require_once __DIR__ . '/../conexion.php';

$trackingUrl = rtrim(getenv('TRACKING_SERVER_URL') ?: 'http://localhost:3000', '/');
$pasteleriaLat = (float) (getenv('PASTELERIA_LAT') ?: 7.077154857097324);
$pasteleriaLng = (float) (getenv('PASTELERIA_LNG') ?: -73.08790648174613);
$pasteleriaDireccion = getenv('PASTELERIA_DIRECCION') ?: 'Kondorito Postres y Pasteles';

$stmt = $pdo->query("
    SELECT
        d.id AS domiciliario_id,
        d.nombre AS domiciliario_nombre,
        d.estado AS domiciliario_estado,
        p.id AS pedido_id,
        p.nombre_usuario,
        p.direccion,
        p.lugar_entrega,
        p.ciudad,
        p.estado_tracking,
        p.lat_entrega,
        p.lng_entrega
    FROM domiciliarios d
    LEFT JOIN pedidos p
        ON p.domiciliario_id = d.id
        AND p.estado_tracking IN ('asignado', 'en_camino')
    ORDER BY d.id ASC, p.actualizado_en DESC
");

$domiciliarios = [];

while ($row = $stmt->fetch()) {
    $id = (int) $row['domiciliario_id'];

    if (!isset($domiciliarios[$id])) {
        $domiciliarios[$id] = [
            'id' => $id,
            'nombre' => $row['domiciliario_nombre'],
            'estado' => $row['domiciliario_estado'],
            'pedido' => null,
        ];
    }

    if ($domiciliarios[$id]['pedido'] === null && !empty($row['pedido_id'])) {
        $domiciliarios[$id]['pedido'] = [
            'id' => (int) $row['pedido_id'],
            'cliente' => $row['nombre_usuario'],
            'direccion' => trim(($row['direccion'] ?? '') . ', ' . ($row['lugar_entrega'] ?? '')),
            'ciudad' => $row['ciudad'],
            'estado_tracking' => $row['estado_tracking'],
            'lat' => $row['lat_entrega'] !== null ? (float) $row['lat_entrega'] : null,
            'lng' => $row['lng_entrega'] !== null ? (float) $row['lng_entrega'] : null,
        ];
    }
}

$domiciliarios = array_values($domiciliarios);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo domiciliarios - Kondorito</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <style>
        #tracking-map {
            position: relative;
            z-index: 0;
        }

        #tracking-map .leaflet-pane,
        #tracking-map .leaflet-control {
            z-index: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-pink-50 to-yellow-50 min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-72 bg-white shadow-2xl min-h-screen p-8 hidden lg:block">
            <div class="flex items-center gap-4 mb-14">
                <div class="w-14 h-14 rounded-full bg-yellow-200 flex items-center justify-center">
                    <i class="fas fa-birthday-cake text-2xl text-amber-900"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-amber-900">Kondorito</h1>
                    <p class="text-gray-500">Administracion</p>
                </div>
            </div>

            <nav class="space-y-4">
                <a href="admin.php" class="flex items-center gap-4 hover:bg-orange-50 p-4 rounded-2xl transition">
                    <i class="fas fa-chart-line text-orange-500"></i>
                    Panel administrativo
                </a>
                <a href="pedidos.php" class="flex items-center gap-4 hover:bg-orange-50 p-4 rounded-2xl transition">
                    <i class="fas fa-receipt text-pink-500"></i>
                    Pedidos
                </a>
                <a href="inventario.php" class="flex items-center gap-4 hover:bg-orange-50 p-4 rounded-2xl transition">
                    <i class="fas fa-box-open text-orange-500"></i>
                    Inventario
                </a>
                <a href="monitoreo_domiciliarios.php" class="flex items-center gap-4 bg-orange-100 p-4 rounded-2xl font-bold text-amber-900">
                    <i class="fas fa-map-location-dot text-blue-500"></i>
                    Monitoreo
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-4 sm:p-8 lg:p-10">
            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5 mb-8">
                <div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-amber-900">Monitoreo de domiciliarios</h1>
                    <p class="text-gray-600 mt-2 text-lg">Ubicacion en tiempo real de domiciliarios y pedidos.</p>
                </div>

                <a href="admin.php" class="inline-flex items-center justify-center gap-3 rounded-2xl bg-white px-5 py-3 font-bold text-amber-900 shadow-lg border border-orange-100">
                    <i class="fas fa-arrow-left"></i>
                    Volver al panel
                </a>
            </div>

            <div class="grid xl:grid-cols-[1fr_360px] gap-6">
                <section class="bg-white rounded-[30px] shadow-2xl overflow-hidden border border-orange-100">
                    <div id="tracking-map" class="h-[68vh] min-h-[520px] w-full"></div>
                </section>

                <aside class="space-y-4">
                    <?php foreach ($domiciliarios as $domiciliario): ?>
                        <div class="bg-white rounded-[26px] shadow-xl border border-orange-100 p-5" data-courier-card="<?= htmlspecialchars((string) $domiciliario['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <h2 class="text-2xl font-bold text-amber-900">
                                        <?= htmlspecialchars($domiciliario['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        ID <?= htmlspecialchars((string) $domiciliario['id'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-sm font-bold bg-gray-100 text-gray-700" data-courier-status="<?= htmlspecialchars((string) $domiciliario['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($domiciliario['estado'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>

                            <?php if ($domiciliario['pedido']): ?>
                                <div class="mt-4 rounded-2xl bg-orange-50 p-4 text-sm text-gray-700">
                                    <p class="font-bold text-amber-900">Pedido #<?= htmlspecialchars((string) $domiciliario['pedido']['id'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p><?= htmlspecialchars($domiciliario['pedido']['direccion'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p><?= htmlspecialchars($domiciliario['pedido']['ciudad'], ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                            <?php else: ?>
                                <p class="mt-4 text-sm text-gray-500">Sin pedido activo.</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </aside>
            </div>
        </main>
    </div>

    <script>
        const trackingUrl = <?php echo json_encode($trackingUrl); ?>;
        const pasteleria = {
            lat: <?php echo json_encode($pasteleriaLat); ?>,
            lng: <?php echo json_encode($pasteleriaLng); ?>,
            direccion: <?php echo json_encode($pasteleriaDireccion); ?>
        };
        const domiciliarios = <?php echo json_encode($domiciliarios, JSON_UNESCAPED_UNICODE); ?>;
        const colors = {
            1: '#ef4444',
            2: '#2563eb',
            3: '#16a34a'
        };
        const courierMarkers = {};
        const destinationMarkers = {};
        const routeLines = {};

        const map = L.map('tracking-map').setView([pasteleria.lat, pasteleria.lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const bakeryIcon = L.divIcon({
            className: '',
            html: '<div style="width:42px;height:42px;border-radius:14px;background:#fef3c7;border:3px solid #8b3f0b;display:grid;place-items:center;font-size:23px;box-shadow:0 10px 24px rgba(0,0,0,.18)">🏠</div>',
            iconSize: [42, 42],
            iconAnchor: [21, 21]
        });

        L.marker([pasteleria.lat, pasteleria.lng], { icon: bakeryIcon })
            .addTo(map)
            .bindPopup(`<strong>Kondorito</strong><br>${pasteleria.direccion}`);

        function makeIcon(color, label) {
            return L.divIcon({
                className: '',
                html: `<div style="width:42px;height:42px;border-radius:999px;background:${color};color:white;display:grid;place-items:center;font-weight:900;font-size:18px;border:3px solid white;box-shadow:0 10px 24px rgba(0,0,0,.25)">🏍</div>`,
                iconSize: [42, 42],
                iconAnchor: [21, 21]
            });
        }

        function makeDestinationIcon(color) {
            return L.divIcon({
                className: '',
                html: `<div style="width:34px;height:34px;border-radius:999px;background:white;border:4px solid ${color};display:grid;place-items:center;font-size:15px;box-shadow:0 8px 20px rgba(0,0,0,.22)">●</div>`,
                iconSize: [34, 34],
                iconAnchor: [17, 17]
            });
        }

        function updateStatus(id, status) {
            const element = document.querySelector(`[data-courier-status="${id}"]`);

            if (!element) return;

            element.textContent = status;
            element.className = 'rounded-full px-3 py-1 text-sm font-bold ' + (
                status === 'disponible'
                    ? 'bg-green-100 text-green-700'
                    : status === 'ocupado'
                        ? 'bg-blue-100 text-blue-700'
                        : 'bg-gray-100 text-gray-700'
            );
        }

        domiciliarios.forEach((domiciliario) => {
            const color = colors[domiciliario.id] || '#f97316';

            if (domiciliario.pedido && domiciliario.pedido.lat && domiciliario.pedido.lng) {
                destinationMarkers[domiciliario.id] = L.marker(
                    [domiciliario.pedido.lat, domiciliario.pedido.lng],
                    { icon: makeDestinationIcon(color) }
                ).addTo(map).bindPopup(
                    `<strong>Destino ${domiciliario.nombre}</strong><br>Pedido #${domiciliario.pedido.id}<br>${domiciliario.pedido.direccion}`
                );
            }

            updateStatus(domiciliario.id, domiciliario.estado);
        });

        const socket = io(trackingUrl, {
            transports: ['websocket']
        });

        socket.on('ubicacion_domiciliario', ({ id, lat, lng }) => {
            const courierId = Number(id);
            const domiciliario = domiciliarios.find((item) => Number(item.id) === courierId);
            const color = colors[courierId] || '#f97316';
            const position = [Number(lat), Number(lng)];

            if (!courierMarkers[courierId]) {
                courierMarkers[courierId] = L.marker(position, {
                    icon: makeIcon(color)
                }).addTo(map).bindPopup(`<strong>${domiciliario ? domiciliario.nombre : 'Domiciliario ' + courierId}</strong>`);
            } else {
                courierMarkers[courierId].setLatLng(position);
            }

            updateStatus(courierId, 'conectado');

            if (domiciliario && domiciliario.pedido && domiciliario.pedido.lat && domiciliario.pedido.lng) {
                const destination = [domiciliario.pedido.lat, domiciliario.pedido.lng];

                if (routeLines[courierId]) {
                    map.removeLayer(routeLines[courierId]);
                }

                routeLines[courierId] = L.polyline([position, destination], {
                    color,
                    weight: 4,
                    opacity: 0.8,
                    dashArray: '8 8'
                }).addTo(map);
            }
        });
    </script>
</body>
</html>
