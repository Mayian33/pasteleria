<?php
session_start();
require 'config.php';
require '../../php/conexion.php';

// Guardar datos del cliente
$cliente = [
  'nombre'    => $_POST['nombre'] ?? '',
  'email'     => $_POST['email'] ?? '',
  'telefono'  => $_POST['telefono'] ?? '',
  'direccion' => $_POST['direccion'] ?? '',
  'ciudad'    => $_POST['ciudad'] ?? '',
  'cp'        => $_POST['cp'] ?? '',
  'provincia' => $_POST['provincia'] ?? '',
  'pais'      => $_POST['pais'] ?? '',
];

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Debes iniciar sesión.'); window.location.href='carrito.php';</script>";
    exit(); 
}

$usuario_id = $_SESSION['usuario_id'];

// Cargar productos del carrito
$stmt = $conn->prepare("SELECT c.id_carrito, c.producto_id, pr.nombre_prod, pr.precio AS producto_precio, pm.precio_personalizacion, pm.id_personalizacion
                        FROM carrito c
                        LEFT JOIN productos pr ON c.producto_id = pr.id_prod
                        LEFT JOIN personalizacion pm ON c.personalizacion_id = pm.id_personalizacion
                        WHERE c.usuario_carrito = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$carrito_items = [];
$total = 0;
$line_items = [];

while ($item = $result->fetch_assoc()) {
    $id_carrito = $item['id_carrito'];
    $cantidad = $_SESSION['carrito'][$id_carrito]['cantidad'] ?? 1;

    $nombre = $item['nombre_prod'] ?? 'Tarta personalizada';
    $precio = $item['producto_precio'] ?? $item['precio_personalizacion'] ?? 0;

    $carrito_items[$id_carrito] = [
        'producto_id' => $item['producto_id'],
        'personalizacion_id' => $item['id_personalizacion'],
        'cantidad' => $cantidad
    ];

    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => ['name' => $nombre],
            'unit_amount' => intval($precio * 100),
        ],
        'quantity' => $cantidad,
    ];

    $total += $precio * $cantidad;
}


// Crear un token único
$token = bin2hex(random_bytes(16));

// Guardar la info temporal en archivo JSON
$temp_data = [
    'usuario_id' => $usuario_id,
    'tipo' => 'compra', // << AÑADIR ESTO
    'cliente' => $cliente,
    'carrito' => $carrito_items,
    'total' => $total
];


file_put_contents(__DIR__ . "/temp_" . $token . ".json", json_encode($temp_data));

// Crear sesión de pago en Stripe
$YOUR_DOMAIN = 'http://localhost/PROYECTO/pasteleria/';
$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => $line_items,
    'mode' => 'payment',
'success_url' => $YOUR_DOMAIN . 'pages/stripe/success.php?token=' . $token . '&tipo=compra',
    'cancel_url' => $YOUR_DOMAIN . 'pages/stripe/cancel.html',
]);

header("Location: " . $checkout_session->url);
exit;
?>
