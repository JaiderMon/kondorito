<?php

require_once __DIR__ . '/../cargar_env.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Use an environment variable for the Stripe key instead of storing it in source control.
\Stripe\Stripe::setApiKey(getenv('STRIPE_API_KEY'));

header('Content-Type: application/json');

$cart = json_decode(file_get_contents("php://input"), true);

if (!is_array($cart) || count($cart) === 0) {
    http_response_code(400);
    echo json_encode([
        'error' => 'El carrito esta vacio.'
    ]);
    exit();
}

$line_items = [];

foreach ($cart as $item) {

    $line_items[] = [

        'price_data' => [

            'currency' => 'cop',

            'product_data' => [
                'name' => $item['name']
            ],

            'unit_amount' => intval($item['price'] * 100)

        ],

        'quantity' => $item['quantity']

    ];

}

$YOUR_DOMAIN = rtrim(getenv('APP_URL') ?: 'http://localhost/kondorito', '/');

try {
    $checkout_session = \Stripe\Checkout\Session::create([

        'line_items' => $line_items,

        'mode' => 'payment',

        'success_url' => $YOUR_DOMAIN . '/success.php',

        'cancel_url' => $YOUR_DOMAIN . '/cancel.php',

    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'No se pudo iniciar el pago con Stripe.'
    ]);
    exit();
}

echo json_encode([

    'url' => $checkout_session->url

]);
