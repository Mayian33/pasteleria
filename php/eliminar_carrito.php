<?php
session_start();
include_once('../php/conexion.php');

if (!isset($_SESSION['usuario_id']) || !isset($_POST['id_carrito'])) {
    header("Location: ../pages/carrito.php");
    exit;
}

$id_carrito = $_POST['id_carrito'];
$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("DELETE FROM carrito WHERE id_carrito = ? AND usuario_carrito = ?");
$stmt->bind_param("ii", $id_carrito, $usuario_id);
$stmt->execute();

header("Location: ../pages/carrito.php");
exit;
