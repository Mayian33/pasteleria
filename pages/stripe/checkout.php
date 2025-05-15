<?php
// 1. Guardar datos del cliente en sesión
session_start();
$_SESSION['cliente'] = [
  'nombre'    => $_POST['nombre'] ?? '',
  'email'     => $_POST['email'] ?? '',
  'telefono'  => $_POST['telefono'] ?? '',
  'direccion' => $_POST['direccion'] ?? '',
  'ciudad'    => $_POST['ciudad'] ?? '',
  'cp'        => $_POST['cp'] ?? '',
  'provincia' => $_POST['provincia'] ?? '',
  'pais'      => $_POST['pais'] ?? '',
];

// 2. Cargar Stripe y BD
require 'config.php';
require '../../php/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Debes iniciar sesión.'); window.location.href='carrito.php';</script>";
    exit(); 
}

$usuario_id = $_SESSION['usuario_id'];

// 3. Consultar productos en carrito
$stmt = $conn->prepare("SELECT c.id_carrito, 
                               pr.nombre_prod, 
                               pr.precio AS producto_precio, 
                               pm.precio_personalizacion, 
                               pm.id_personalizacion
                        FROM carrito c
                        LEFT JOIN productos pr ON c.producto_id = pr.id_prod
                        LEFT JOIN personalizacion pm ON c.personalizacion_id = pm.id_personalizacion
                        WHERE c.usuario_carrito = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$line_items = [];
$total = 0;

while ($item = $result->fetch_assoc()) {
    $cantidad = isset($_SESSION['carrito'][$item['id_carrito']]['cantidad']) ? $_SESSION['carrito'][$item['id_carrito']]['cantidad'] : 1;
    $nombre = $item['nombre_prod'] ?? 'Tarta personalizada';
    $precio = $item['producto_precio'] ?? $item['precio_personalizacion'] ?? 0;

    // Añadir al array de Stripe
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $nombre,
            ],
            'unit_amount' => intval($precio * 100),
        ],
        'quantity' => $cantidad,
    ];

    // Calcular total en euros
    $total += $precio * $cantidad;
}

// 4. Guardar el total calculado
$_SESSION['total_pedido'] = $total;

// 5. Crear sesión de pago en Stripe
$YOUR_DOMAIN = 'http://localhost/PROYECTO/pasteleria/';

$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . 'php/success.php',
    'cancel_url' => $YOUR_DOMAIN . 'pages/stripe/cancel.html',
]);

header("Location: " . $checkout_session->url);
exit;
