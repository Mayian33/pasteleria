<?php
session_start();
include_once('conexion.php');

header('Content-Type: application/json');

$response = ['status' => '', 'message' => ''];

if (!isset($_SESSION['usuario_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'Debes iniciar sesión para añadir productos al carrito.';
    echo json_encode($response);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
$fecha = date("Y-m-d H:i:s");

if ($producto_id <= 0) {
    $response['status'] = 'error';
    $response['message'] = 'ID de producto inválido.';
    echo json_encode($response);
    exit;
}

// Verificar si ya existe en el carrito
$verificar = $conn->prepare("SELECT id_carrito FROM carrito WHERE usuario_carrito = ? AND producto_id = ? AND personalizacion_id IS NULL");
$verificar->bind_param("ii", $usuario_id, $producto_id);
$verificar->execute();
$verificar->store_result();

if ($verificar->num_rows > 0) {
    $response['status'] = 'duplicado';
    $response['message'] = 'Este producto ya está en tu carrito. Puedes modificar la cantidad desde allí.';
} else {
    $insertar = $conn->prepare("INSERT INTO carrito (usuario_carrito, producto_id, fecha_carrito) VALUES (?, ?, ?)");
    $insertar->bind_param("iis", $usuario_id, $producto_id, $fecha);
    if ($insertar->execute()) {
        $response['status'] = 'ok';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error al añadir el producto.';
    }
}

echo json_encode($response);
