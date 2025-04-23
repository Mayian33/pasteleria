<?php
session_start();
include_once('conexion.php');

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Verifica si se recibió un producto por GET
if (isset($_GET['id'])) {
    $producto_id = intval($_GET['id']);
    $fecha = date('d-m-Y');

    // Aquí insertas un pedido nuevo con ese producto
    $sql = "INSERT INTO pedidos (usuario_pedido, producto_id, fecha_pedido) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $usuario_id, $producto_id, $fecha);

    if ($stmt->execute()) {
        header("Location: carrito.php");
        exit;
    } else {
        echo "Error al añadir al carrito.";
    }
} else {
    echo "Producto no especificado.";
}
