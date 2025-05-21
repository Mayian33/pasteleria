<?php
session_start();
require 'config.php';
require '../../php/conexion.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Producto no válido');
}

$id_producto = intval($_GET['id']);

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Debes iniciar sesión.'); window.location.href='../login.php';</script>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener el producto
$sql = "SELECT nombre_prod, precio FROM productos WHERE id_prod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die('Producto no encontrado');
}

$producto = $result->fetch_assoc();

// Crear token y guardar datos
$token = bin2hex(random_bytes(16));
$temp_data = [
    'usuario_id' => $usuario_id,
    'producto_id' => $id_producto,
    'tipo' => 'donacion',
    'monto' => $producto['precio']
];
file_put_contents(__DIR__ . "/temp_" . $token . ".json", json_encode($temp_data));

// Crear sesión de Stripe con transferencia a cuenta conectada
$YOUR_DOMAIN = 'http://localhost/PROYECTO/pasteleria/';

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Donación con producto: ' . $producto['nombre_prod'],
                'description' => 'Este pago será enviado directamente a una asociación solidaria.',
            ],
            'unit_amount' => intval($producto['precio'] * 100),
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'payment_intent_data' => [
        'transfer_data' => [
            'destination' => 'acct_1RRGcoHCHru9cSIo', // TU CUENTA CONECTADA EN SANDBOX
        ]
    ],
    'success_url' => $YOUR_DOMAIN . 'pages/stripe/success.php?token=' . $token,
    'cancel_url' => $YOUR_DOMAIN . 'pages/catalogue.php',
]);

header("Location: " . $checkout_session->url);
exit;
