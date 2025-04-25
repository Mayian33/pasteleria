<?php
session_start();
include_once('conexion.php');

if (!isset($_SESSION['usuario_id']) || !isset($_POST['id_pedido'])) {
    header("Location: carrito.php");
    exit;
}

$id_pedido = $_POST['id_pedido'];
$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("DELETE FROM pedidos WHERE id_pedido = ? AND usuario_pedido = ?");
$stmt->bind_param("ii", $id_pedido, $usuario_id);
$stmt->execute();

header("Location: carrito.php");
exit;
?>
