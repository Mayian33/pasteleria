<?php
// Inicia la sesión para acceder a los datos del usuario
session_start();

// Carga configuración de Stripe y la conexión a la base de datos
require 'config.php';
require '../../php/conexion.php';

// Guarda los datos del cliente recibidos por POST (formulario de pago)
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

// Verifica si el usuario ha iniciado sesión, si no, lo redirige al carrito
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Debes iniciar sesión.'); window.location.href='carrito.php';</script>";
    exit(); 
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta los productos que el usuario tiene en el carrito
$stmt = $conn->prepare("SELECT c.id_carrito, c.producto_id, pr.nombre_prod, pr.precio AS producto_precio, pm.precio_personalizacion, pm.id_personalizacion
                        FROM carrito c
                        LEFT JOIN productos pr ON c.producto_id = pr.id_prod
                        LEFT JOIN personalizacion pm ON c.personalizacion_id = pm.id_personalizacion
                        WHERE c.usuario_carrito = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Inicializa variables para almacenar ítems del carrito y el total
$carrito_items = [];
$total = 0;
$line_items = []; // Usado para crear la sesión de pago en Stripe

// Procesa cada producto del carrito
while ($item = $result->fetch_assoc()) {
    $id_carrito = $item['id_carrito'];
    $cantidad = $_SESSION['carrito'][$id_carrito]['cantidad'] ?? 1;

    // Si es producto estándar, usa el nombre; si es personalización, nombre genérico
    $nombre = $item['nombre_prod'] ?? 'Tarta personalizada';
    
    // Usa el precio del producto o, si no hay, el de la personalización
    $precio = $item['producto_precio'] ?? $item['precio_personalizacion'] ?? 0;

    // Guarda el ítem con su cantidad para luego insertarlo en pedido
    $carrito_items[$id_carrito] = [
        'producto_id' => $item['producto_id'],
        'personalizacion_id' => $item['id_personalizacion'],
        'cantidad' => $cantidad
    ];

    // Formatea los datos del producto para Stripe (precio en céntimos)
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => ['name' => $nombre],
            'unit_amount' => intval($precio * 100),
        ],
        'quantity' => $cantidad,
    ];

    $total += $precio * $cantidad; // Suma al total
}

// Crea un token único que se usará para guardar temporalmente los datos de compra
$token = bin2hex(random_bytes(16));

// Almacena todos los datos de esta compra en un archivo JSON temporal
$temp_data = [
    'usuario_id' => $usuario_id,
    'tipo' => 'compra', // Se usa para saber qué tipo de operación es
    'cliente' => $cliente,
    'carrito' => $carrito_items,
    'total' => $total
];

// Guarda los datos en un archivo como temp_abcd1234.json
file_put_contents(__DIR__ . "/temp_" . $token . ".json", json_encode($temp_data));

// Define el dominio para la redirección después del pago
$YOUR_DOMAIN = 'http://localhost/PROYECTO/pasteleria/';

// Crea una sesión de pago en Stripe con los datos del carrito
$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => $line_items, // Productos y cantidades
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . 'pages/stripe/success.php?token=' . $token . '&tipo=compra',
    'cancel_url' => $YOUR_DOMAIN . 'pages/stripe/cancel.html',
]);

// Redirige al usuario a Stripe para completar el pago
header("Location: " . $checkout_session->url);
exit;
?>
