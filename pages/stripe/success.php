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
    echo "<p>Error: No se encontró la información del pedido.</p>";
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

    echo "<h1>🎉 ¡Gracias por tu compra!</h1>";
    echo "<p>Tu pedido ha sido registrado correctamente.</p>";
    echo '<a href="../pages/catalogue.php">Volver al catálogo</a>';
} else {
    echo "<p><strong>❌ Error al guardar el pedido:</strong> " . $stmt->error . "</p>";
}
?>
