<?php

require 'vendor/autoload.php';

// Use an environment variable for the Stripe key instead of storing it in source control.
\Stripe\Stripe::setApiKey(getenv('STRIPE_API_KEY'));

header('Content-Type: application/json');

$cart = json_decode(file_get_contents("php://input"), true);

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

$YOUR_DOMAIN = 'http://localhost/kondorito';

$checkout_session = \Stripe\Checkout\Session::create([

    'line_items' => $line_items,

    'mode' => 'payment',

    'success_url' => $YOUR_DOMAIN . '/success.php',

    'cancel_url' => $YOUR_DOMAIN . '/cancel.php',

]);

echo json_encode([

    'url' => $checkout_session->url

]);