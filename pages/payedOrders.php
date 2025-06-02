<?php
session_start();
include_once('../php/layout.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Por favor, inicia sesión para ver tu historial.'); window.location.href='../pages/compra.php';</script>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta completa con detalles de producto y personalización
$sql = "SELECT 
    p.*, 
    dp.*, 
    e.nombre_estado,
    pr.nombre_prod,
    per.id_personalizacion,
    t.nombre_tamano,
    m.nombre_masa,
    s.nombre_sabor,
    d.nombre_decoracion,
    per.tamano_personalizacion,
    per.masa_personalizacion,
    per.sabor_personalizacion,
    per.decoracion_personalizacion
FROM pedidos p
JOIN detalle_pedido dp ON p.pedido_id = dp.pedido_id
JOIN estados e ON p.estado_pedido = e.id_estado
LEFT JOIN productos pr ON dp.producto_id = pr.id_prod
LEFT JOIN personalizacion per ON dp.personalizacion_id = per.id_personalizacion
LEFT JOIN tamano t ON per.tamano_personalizacion = t.id_tamano
LEFT JOIN masa m ON per.masa_personalizacion = m.id_masa
LEFT JOIN sabor s ON per.sabor_personalizacion = s.id_sabor
LEFT JOIN decoracion d ON per.decoracion_personalizacion = d.id_decoracion
WHERE p.usuario_id = ?
ORDER BY p.fecha_pedido DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Agrupar los productos por pedido
$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[$row['pedido_id']][] = $row;
}

// Consulta adicional para donaciones del usuario
$sql_donaciones = "SELECT d.*, p.nombre_prod 
                   FROM donacion d 
                   JOIN productos p ON d.producto_donacion = p.id_prod 
                   WHERE d.usuario_donacion = ? 
                   ORDER BY d.fecha_donacion DESC";
$stmt_don = $conn->prepare($sql_donaciones);
$stmt_don->bind_param("i", $usuario_id);
$stmt_don->execute();
$result_don = $stmt_don->get_result();

$donaciones = [];
while ($row = $result_don->fetch_assoc()) {
    $donaciones[] = $row;
}

// Fusionar pedidos y donaciones
$pedidos_flat = [];
foreach ($pedidos as $pedido_id => $productos) {
    $pedidos_flat[] = [
        'tipo' => 'pedido',
        'fecha' => $productos[0]['fecha_pedido'],
        'estado' => $productos[0]['nombre_estado'],
        'precio' => $productos[0]['total_pedido'],
        'productos' => $productos
    ];
}

foreach ($donaciones as $d) {
    $pedidos_flat[] = [
        'tipo' => 'donacion',
        'fecha' => $d['fecha_donacion'],
        'estado' => $productos[0]['nombre_estado'],
        'precio' => $d['monto_donacion'],
        'producto_nombre' => $d['nombre_prod'],
        'donacion_monto' => $d['monto_donacion']
    ];
}

usort($pedidos_flat, function ($a, $b) {
    return strtotime($b['fecha']) - strtotime($a['fecha']);
});
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/payedOrders.css" as="style" />
    <link href="../css/payedOrders.css" rel="stylesheet" />
</head>

<body>
    <header>
        <?php echo $Menu ?>
    </header>

    <section class="main">
        <h2 class="subtitle-text">Historial de Pedidos</h2>
        <div class="white-container">
            <?php if (!empty($pedidos)): ?>
                <?php if (!empty($pedidos)): ?>
                 

                        <?php foreach ($pedidos_flat as $item): ?>
                            <?php if ($item['estado'] === 'archivar') continue; ?>
                            <div class="orders">
                                <div class="order-card">
                                    <div class="order-details">
                                        <h3 class="title-text common-text">Fecha: <?= htmlspecialchars($item['fecha']) ?></h3>
                                        <p class="common-text"><strong>Tipo:</strong> <?= $item['tipo'] === 'pedido' ? 'Pedido' : 'Donación' ?></p>
                                        <p class="common-text"><strong>Precio:</strong> <?= number_format($item['precio'], 2) ?> €</p>

                                        <?php if ($item['tipo'] === 'pedido'): ?>
                                            <p class="common-text"><strong>Estado:</strong> <?= htmlspecialchars($item['estado']) ?></p>
                                            <div class="productos-pedido">
                                                <?php foreach ($item['productos'] as $producto): ?>
                                                    <div class="producto-detalle">
                                                        <?php if (!empty($producto['nombre_prod'])): ?>
                                                            <p class="common-text"><strong>Producto:</strong> <?= htmlspecialchars($producto['nombre_prod']) ?></p>
                                                        <?php elseif (!empty($producto['id_personalizacion'])): ?>
                                                            <p class="common-text"><strong>Producto personalizado</strong></p>
                                                            <ul class="common-text">
                                                                <li><strong>Tamaño:</strong> <?= htmlspecialchars($producto['nombre_tamano'] ?? 'No especificado') ?></li>
                                                                <li><strong>Masa:</strong> <?= htmlspecialchars($producto['nombre_masa'] ?? 'No especificado') ?></li>
                                                                <li><strong>Sabor:</strong> <?= htmlspecialchars($producto['nombre_sabor'] ?? 'No especificado') ?></li>
                                                                <li><strong>Decoración:</strong> <?= htmlspecialchars($producto['nombre_decoracion'] ?? 'No especificado') ?></li>
                                                            </ul>
                                                        <?php endif; ?>
                                                        <p class="common-text"><strong>Cantidad:</strong> <?= $producto['cantidad'] ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php elseif ($item['tipo'] === 'donacion'): ?>
                                            <p class="common-text"><strong>Donación para:</strong> <?= htmlspecialchars($item['producto_nombre']) ?></p>
                                            <p class="common-text donacion-frase">
                                                ¡Gracias por tu generosa donación! Ayudas a endulzar la vida de quienes más lo necesitan. 🩷
                                            </p>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


             
                <?php else: ?>
                    <p class="common-text">No tienes pedidos registrados.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="common-text">No tienes pedidos registrados.</p>
            <?php endif; ?>

        </div>

        <div class="cta-catalogue">
            <a href="../pages/catalogue.php" class="cta-btn">Hacer nuevo pedido</a>
        </div>

        <?php echo $Footer ?>
    </section>
</body>

</html>