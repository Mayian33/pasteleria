<?php
session_start();
include_once('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) { 
    echo "<script>alert('Por favor, inicia sesión para ver tu carrito.'); window.location.href='../pages/compra.php';</script>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
 // Usamos 'id_usuario' aquí también

if (isset($_GET['id'])) {
    $producto_id = intval($_GET['id']);
    $fecha = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO carrito (usuario_carrito, producto_id, fecha_carrito) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $usuario_id, $producto_id, $fecha);
    $stmt->execute();
}

// Redirigir al carrito después de añadir el producto
header("Location: ../pages/carrito.php");
exit();
?>
