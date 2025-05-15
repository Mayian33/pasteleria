<?php
session_start();
require './conexion.php';

// Verificar que existen todos los datos necesarios
if (!isset($_SESSION['usuario_id'], $_SESSION['cliente'], $_SESSION['carrito'])) {
    echo "<script>alert('No se ha podido registrar el pedido'); window.location.href='../pages/catalogue.php';</script>";
    exit();
}

// Datos del cliente y pedido
$cliente = $_SESSION['cliente'];
$usuario_id = $_SESSION['usuario_id'];
$total = $_SESSION['total_pedido'] ?? 0.00;
$nombre_pedido = "Pedido de " . $cliente['nombre'];
$fecha = date("Y-m-d H:i:s");
$estado_id = 1; // Estado por defecto: Recibido

// Insertar en pedidos (sin precio_detalle ni dirección dividida)
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

    // Obtener productos del carrito
    $query = $conn->prepare("SELECT c.id_carrito, c.producto_id, c.personalizacion_id
                             FROM carrito c
                             WHERE c.usuario_carrito = ?");
    $query->bind_param("i", $usuario_id);
    $query->execute();
    $carrito_result = $query->get_result();

    if ($carrito_result->num_rows > 0) {
        while ($item = $carrito_result->fetch_assoc()) {
            $id_carrito = $item['id_carrito'];
            $producto_id = $item['producto_id'] ?? null;
            $personalizacion_id = $item['personalizacion_id'] ?? null;
            $cantidad = $_SESSION['carrito'][$id_carrito]['cantidad'] ?? 1;

            // Insertar en detalle_pedido (sin precio)
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

        // Vaciar el carrito
        $conn->query("DELETE FROM carrito WHERE usuario_carrito = $usuario_id");
        unset($_SESSION['carrito'], $_SESSION['total_pedido'], $_SESSION['cliente']);

        // Confirmación
        echo "<h1>🎉 ¡Gracias por tu compra!</h1>";
        echo "<p>Tu pedido ha sido registrado correctamente.</p>";
        echo '<a href="../pages/catalogue.php">Volver al catálogo</a>';
    } else {
        echo "<p>⚠️ El carrito estaba vacío. El pedido se ha creado, pero no contiene productos.</p>";
    }
} else {
    echo "<p>Error al guardar el pedido: " . $stmt->error . "</p>";
}
?>
