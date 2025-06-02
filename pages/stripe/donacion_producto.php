<?php
session_start();
require 'config.php';
require '../../php/conexion.php';

// Validación de producto
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Producto no válido');
}

$id_producto = intval($_GET['id']);

// Validación de sesión
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
$donacion_extra = 5.00; // Cambia este valor a 3, 4, etc. según el extra que quieras donar
$precio_final = $producto['precio'] + $donacion_extra;

$token = bin2hex(random_bytes(16));
$temp_data = [
    'usuario_id' => $usuario_id,
    'producto_id' => $id_producto,
    'tipo' => 'donacion',
    'monto_total' => $precio_final,
    'monto_donacion' => $donacion_extra
];
file_put_contents(__DIR__ . "/temp_" . $token . ".json", json_encode($temp_data));


// Crear sesión de Stripe SIN transfer_data para que todo el dinero vaya a la pastelera
$YOUR_DOMAIN = 'http://localhost/PROYECTO/pasteleria/';

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Donación con producto: ' . $producto['nombre_prod'],
                'description' => 'Una parte del pago será donada a una asociación solidaria.',
            ],
            'unit_amount' => intval($precio_final * 100), // el nuevo precio con donación incluida
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    // quitamos la transferencia directa a la cuenta conectada
    // y dejamos que todo vaya a la cuenta principal
    'success_url' => $YOUR_DOMAIN . 'pages/stripe/success.php?token=' . $token,
    'cancel_url' => $YOUR_DOMAIN . 'pages/catalogue.php',
]);

// Redirigir al pago
header("Location: " . $checkout_session->url);
exit;
