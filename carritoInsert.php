<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();  // Esto siempre debe estar al principio de cada archivo PHP que utilice la sesión
include_once('conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");  // Si no está logueado, redirige a login
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if (isset($_GET['id'])) {
    $producto_id = intval($_GET['id']);
    $fecha = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO pedidos (usuario_pedido, producto_id, fecha_pedido) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $usuario_id, $producto_id, $fecha);
    $stmt->execute();
}

header("Location: carrito.php");
exit();
?>
