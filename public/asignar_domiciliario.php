<?php

require_once __DIR__ . '/../conexion.php';

function volverConMensaje(string $tipo, string $mensaje, string $fecha): void
{
    header('Location: admin.php?fecha=' . urlencode($fecha) . '&' . $tipo . '=' . urlencode($mensaje));
    exit();
}

function requestJson(string $url, string $method = 'GET', ?array $payload = null): array
{
    $options = [
        'http' => [
            'method' => $method,
            'header' => "Content-Type: application/json\r\n",
            'ignore_errors' => true,
            'timeout' => 15,
        ],
    ];

    if ($payload !== null) {
        $options['http']['content'] = json_encode($payload);
    }

    $response = @file_get_contents($url, false, stream_context_create($options));

    if ($response === false) {
        throw new RuntimeException('No se pudo contactar el servidor de tracking.');
    }

    $data = json_decode($response, true);

    if (!is_array($data)) {
        throw new RuntimeException('El servidor de tracking respondio con un formato invalido.');
    }

    return $data;
}

$pedidoId = filter_input(INPUT_POST, 'pedido_id', FILTER_VALIDATE_INT);
$domiciliarioId = filter_input(INPUT_POST, 'domiciliario_id', FILTER_VALIDATE_INT);
$fecha = $_POST['fecha'] ?? date('Y-m-d');

if (!$pedidoId || !$domiciliarioId) {
    volverConMensaje('error', 'Debes seleccionar un pedido y un domiciliario validos.', $fecha);
}

try {
    $stmtPedido = $pdo->prepare("
        SELECT id, direccion, lugar_entrega, indicaciones_entrega, ciudad, nombre_usuario, lat_entrega, lng_entrega
        FROM pedidos
        WHERE id = :id
        LIMIT 1
    ");
    $stmtPedido->execute(['id' => $pedidoId]);
    $pedido = $stmtPedido->fetch();

    if (!$pedido) {
        volverConMensaje('error', 'El pedido no existe.', $fecha);
    }

    $stmtDomiciliario = $pdo->prepare("
        SELECT id, nombre
        FROM domiciliarios
        WHERE id = :id
        LIMIT 1
    ");
    $stmtDomiciliario->execute(['id' => $domiciliarioId]);
    $domiciliario = $stmtDomiciliario->fetch();

    if (!$domiciliario) {
        volverConMensaje('error', 'El domiciliario no existe.', $fecha);
    }

    $trackingUrl = rtrim(getenv('TRACKING_SERVER_URL') ?: 'http://localhost:3000', '/');
    $deliveryLat = filter_var($pedido['lat_entrega'] ?? null, FILTER_VALIDATE_FLOAT);
    $deliveryLng = filter_var($pedido['lng_entrega'] ?? null, FILTER_VALIDATE_FLOAT);

    if ($deliveryLat === false || $deliveryLng === false) {
        $direccionBusqueda = trim($pedido['direccion'] . ', ' . $pedido['lugar_entrega'] . ', ' . $pedido['ciudad'] . ', Santander, Colombia');
        $sugerencias = requestJson($trackingUrl . '/buscar-direccion?q=' . urlencode($direccionBusqueda));

        if (count($sugerencias) === 0 || empty($sugerencias[0]['lat']) || empty($sugerencias[0]['lon'])) {
            volverConMensaje('error', 'No se pudieron obtener coordenadas para la direccion del pedido.', $fecha);
        }

        $deliveryLat = (float) $sugerencias[0]['lat'];
        $deliveryLng = (float) $sugerencias[0]['lon'];
    }

    $descripcion = 'Pedido #' . $pedido['id'] . ' - ' . $pedido['nombre_usuario'];

    if (!empty($pedido['indicaciones_entrega'])) {
        $descripcion .= ' - ' . $pedido['indicaciones_entrega'];
    }

    $respuesta = requestJson($trackingUrl . '/asignar-pedido', 'POST', [
        'pedidoId' => $pedidoId,
        'domiciliarioId' => $domiciliarioId,
        'deliveryLat' => $deliveryLat,
        'deliveryLng' => $deliveryLng,
        'direccion' => trim($pedido['direccion'] . ', ' . $pedido['lugar_entrega']),
        'descripcion' => $descripcion,
    ]);

    if (empty($respuesta['ok'])) {
        volverConMensaje('error', $respuesta['error'] ?? 'No se pudo asignar el pedido.', $fecha);
    }

    $mensaje = !empty($respuesta['domiciliarioConectado'])
        ? 'Pedido asignado y enviado a la PWA de ' . $domiciliario['nombre'] . '.'
        : 'Pedido asignado a ' . $domiciliario['nombre'] . ', pero el domiciliario no esta conectado.';

    volverConMensaje('ok', $mensaje, $fecha);
} catch (Throwable $error) {
    volverConMensaje('error', $error->getMessage(), $fecha);
}
