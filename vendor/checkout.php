<?php
require 'config.php';

$YOUR_DOMAIN = 'http://localhost/PROYECTO/pasteleria/stripe';

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Tarta de chocolate',
            ],
            'unit_amount' => 2500, // 25€ en céntimos
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/success.html',
    'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

header("Location: " . $checkout_session->url);
exit;
