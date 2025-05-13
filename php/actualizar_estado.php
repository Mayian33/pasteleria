<?php
include_once('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedido_id = intval($_POST['pedido_id']);
    $estado_id = intval($_POST['estado_id']);

    $stmt = $conn->prepare("UPDATE pedidos SET estado_pedido = ? WHERE pedido_id = ?");
    $stmt->bind_param("ii", $estado_id, $pedido_id);

    if ($stmt->execute()) {
        echo "✔ Estado actualizado correctamente.";
    } else {
        echo "❌ Error al actualizar el estado.";
    }

    $stmt->close();
    $conn->close();
}
?>
