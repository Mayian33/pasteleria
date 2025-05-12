<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_carrito = $_POST['id_carrito'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;

    if ($id_carrito !== null && $cantidad !== null && is_numeric($cantidad) && $cantidad > 0) {
        $_SESSION['carrito'][$id_carrito]['cantidad'] = intval($cantidad);
        echo json_encode(['status' => 'ok']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
}
