<?php
session_start();

require_once __DIR__ . '/../conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['correo'], $_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'error' => 'Debes iniciar sesión para registrar el pedido.'
    ]);
    exit();
}

$payload = json_decode(file_get_contents('php://input'), true);
$cart = $payload['cart'] ?? $payload;
$delivery = $payload['delivery'] ?? [];

if (!is_array($cart) || count($cart) === 0) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'error' => 'El carrito está vacío.'
    ]);
    exit();
}

$direccionEntrega = trim($delivery['direccion'] ?? '');
$ciudadEntrega = trim($delivery['ciudad'] ?? '');
$telefonoEntrega = trim($delivery['telefono'] ?? '');
$fechaEntrega = trim($delivery['fecha_entrega'] ?? '');
$horaEntrega = trim($delivery['hora_entrega'] ?? '');
$indicacionesEntrega = trim($delivery['indicaciones_entrega'] ?? '');

if (
    $direccionEntrega === '' ||
    $ciudadEntrega === '' ||
    $telefonoEntrega === '' ||
    $fechaEntrega === '' ||
    $horaEntrega === ''
) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'error' => 'Faltan datos de entrega para registrar el pedido.'
    ]);
    exit();
}

$correoUsuario = $_SESSION['correo'];

$stmtUsuario = $pdo->prepare(
    "SELECT nombre, correo, direccion, ciudad, telefono
     FROM usuarios
     WHERE correo = :correo
     LIMIT 1"
);

$stmtUsuario->execute([
    'correo' => $correoUsuario
]);

$usuario = $stmtUsuario->fetch();

if (!$usuario) {
    http_response_code(404);
    echo json_encode([
        'ok' => false,
        'error' => 'No se encontró el usuario.'
    ]);
    exit();
}

$totalPedido = 0;

foreach ($cart as $item) {
    $precio = (float) ($item['price'] ?? 0);
    $cantidad = (int) ($item['quantity'] ?? 0);

    if ($precio <= 0 || $cantidad <= 0) {
        continue;
    }

    $totalPedido += $precio * $cantidad;
}

if ($totalPedido <= 0) {
    http_response_code(400);
    echo json_encode([
        'ok' => false,
        'error' => 'El total del pedido no es válido.'
    ]);
    exit();
}

try {
    $pdo->beginTransaction();

    $stmtPedido = $pdo->prepare(
        "INSERT INTO pedidos (
            correo_usuario,
            nombre_usuario,
            telefono,
            ciudad,
            direccion,
            fecha_entrega,
            hora_entrega,
            indicaciones_entrega,
            total,
            estado,
            metodo_pago
        ) VALUES (
            :correo_usuario,
            :nombre_usuario,
            :telefono,
            :ciudad,
            :direccion,
            :fecha_entrega,
            :hora_entrega,
            :indicaciones_entrega,
            :total,
            'pagado',
            'stripe'
        )
        RETURNING id"
    );

    $stmtPedido->execute([
        'correo_usuario' => $usuario['correo'],
        'nombre_usuario' => $usuario['nombre'],
        'telefono' => $telefonoEntrega,
        'ciudad' => $ciudadEntrega,
        'direccion' => $direccionEntrega,
        'fecha_entrega' => $fechaEntrega,
        'hora_entrega' => $horaEntrega,
        'indicaciones_entrega' => $indicacionesEntrega !== '' ? $indicacionesEntrega : null,
        'total' => $totalPedido
    ]);

    $pedidoId = $stmtPedido->fetchColumn();

    $stmtDetalle = $pdo->prepare(
        "INSERT INTO detalle_pedidos (
            pedido_id,
            producto_id,
            nombre_producto,
            descripcion_producto,
            imagen_producto,
            categoria,
            tamano,
            relleno,
            descripcion_adicional,
            precio_unitario,
            cantidad,
            subtotal
        ) VALUES (
            :pedido_id,
            :producto_id,
            :nombre_producto,
            :descripcion_producto,
            :imagen_producto,
            :categoria,
            :tamano,
            :relleno,
            :descripcion_adicional,
            :precio_unitario,
            :cantidad,
            :subtotal
        )"
    );

    foreach ($cart as $item) {
        $precio = (float) ($item['price'] ?? 0);
        $cantidad = (int) ($item['quantity'] ?? 0);

        if ($precio <= 0 || $cantidad <= 0) {
            continue;
        }

        $stmtDetalle->execute([
            'pedido_id' => $pedidoId,
            'producto_id' => $item['id'] ?? null,
            'nombre_producto' => $item['name'] ?? 'Producto',
            'descripcion_producto' => $item['description'] ?? null,
            'imagen_producto' => $item['image'] ?? null,
            'categoria' => $item['category'] ?? null,
            'tamano' => $item['size'] ?? null,
            'relleno' => $item['fill'] ?? null,
            'descripcion_adicional' => $item['extra'] ?? null,
            'precio_unitario' => $precio,
            'cantidad' => $cantidad,
            'subtotal' => $precio * $cantidad
        ]);
    }

    $pdo->commit();

    echo json_encode([
        'ok' => true,
        'pedido_id' => $pedidoId
    ]);
} catch (Throwable $e) {
    $pdo->rollBack();

    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'No se pudo registrar el pedido.'
    ]);
}
