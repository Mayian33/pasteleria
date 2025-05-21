    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pago exitoso</title>
        <link rel="preload" href="../../css/estilos-comunes.css" as="style" />
        <link href="../../css/estilos-comunes.css" rel="stylesheet" />
    </head>

    <body>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../vendor/autoload.php';
require '../../php/conexion.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Obtener token desde URL
$token = $_GET['token'] ?? null;
if (!$token || !file_exists(__DIR__ . "/temp_" . $token . ".json")) {
    echo '<div class="container-stripe ">';
    echo '<p class="common-text">❌Error: No se encontró la información del pedido.</p>';
    echo '<a class="cta-btn" href="../catalogue.php">Volver al catálogo</a>';
    echo '</div>';
    exit;
}

// Cargar datos guardados
$data = json_decode(file_get_contents(__DIR__ . "/temp_" . $token . ".json"), true);
unlink(__DIR__ . "/temp_" . $token . ".json"); // eliminar archivo temporal

$cliente = $data['cliente'];
$usuario_id = $data['usuario_id'];
$carrito = $data['carrito'];
$total = $data['total'];

$nombre_pedido = "Pedido de " . $cliente['nombre'];
$fecha = date("Y-m-d");
$estado_id = 1;

$stmt = $conn->prepare("INSERT INTO pedidos 
    (usuario_id, fecha_pedido, total_pedido, estado_pedido, nombre_pedido, email_pedido, telefono_pedido, ciudad, cp, direccion_pedido)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "isidssssss",
    $usuario_id,
    $fecha,
    $total,
    $estado_id,
    $nombre_pedido,
    $cliente['email'],
    $cliente['telefono'],
    $cliente['ciudad'],
    $cliente['cp'],
    $cliente['direccion']
);

if ($stmt->execute()) {
    $pedido_id = $conn->insert_id;

    foreach ($carrito as $id_carrito => $item) {
        $producto_id = $item['producto_id'] ?? null;
        $personalizacion_id = $item['personalizacion_id'] ?? null;
        $cantidad = $item['cantidad'] ?? 1;

        $stmt_detalle = $conn->prepare("INSERT INTO detalle_pedido 
            (pedido_id, producto_id, personalizacion_id, cantidad)
            VALUES (?, ?, ?, ?)");
        $stmt_detalle->bind_param(
            "iiii",
            $pedido_id,
            $producto_id,
            $personalizacion_id,
            $cantidad
        );
        $stmt_detalle->execute();
    }

    $conn->query("DELETE FROM carrito WHERE usuario_carrito = $usuario_id");

    echo '<div class="container-stripe">';
    echo '<h1 class="subtitle-text">🎉 ¡Gracias por tu compra!</h1>';
    echo '<p class="common-text">Tu pedido ha sido registrado correctamente.</p>';
    echo '<a class="cta-btn" href="../catalogue.php">Volver al catálogo</a>';
    echo '</div>';
} else {
    echo '<div class="container-stripe">';
    echo '<p class="common-text">❌ Ocurrió un error al guardar tu pedido. Por favor, inténtalo de nuevo más tarde.</p>';
    echo '<a class="cta-btn" href="../catalogue.php">Volver al catálogo</a>';
    echo '</div>';
}
    ?>

    </body>

    </html>