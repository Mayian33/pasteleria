<?php
require './conexion.php';

foreach ($_POST as $key => $estado_id) {
    if (strpos($key, 'estado_') === 0) {
        $pedido_id = intval(str_replace('estado_', '', $key));
        $estado_id = intval($estado_id);

        $stmt = $conn->prepare("UPDATE pedidos SET estado_pedido = ? WHERE pedido_id = ?");
        $stmt->bind_param("ii", $estado_id, $pedido_id);
        $stmt->execute();
    }
}

header("Location: ../pages/orders.php"); // o tu ruta
exit();
