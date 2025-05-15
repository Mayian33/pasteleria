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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
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

    <style>
        .productos-pedido {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .producto-detalle {
            flex: 1 1 300px;
            border: 1px solid var(--secondary);
            border-radius: 12px;
            padding: 1rem;
            background-color: var(--white);
        }

        .producto-detalle p,
        .producto-detalle ul {
            margin: 0.5rem 0;
        }

        .producto-detalle ul {
            padding-left: 1.2rem;
        }
    </style>

    <main class="main">
        <h2 class="subtitle-text">Historial de Pedidos</h2>

        <div class="orders">
            <?php if (!empty($pedidos)): ?>
                <?php foreach ($pedidos as $pedido_id => $productos): ?>
                    <div class="order-card">
                        <div class="order-details">
                            <h3 class="title-text common-text">Fecha: <?= htmlspecialchars($productos[0]['fecha_pedido']) ?></h3>
                            <p class="common-text"><strong>Estado:</strong> <?= htmlspecialchars($productos[0]['nombre_estado']) ?></p>
                            <?php
                            $total = isset($productos[0]['total_pedido']) ? floatval($productos[0]['total_pedido']) : 0;
                            ?>
                            <p class="common-text"><strong>Precio:</strong> <?= number_format($total, 2) ?> €</p>


                            <div class="productos-pedido">
                                <?php foreach ($productos as $producto): ?>
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
                                        <?php else: ?>
                                            <p class="common-text"><strong>Producto:</strong> Producto desconocido</p>
                                        <?php endif; ?>

                                        <p class="common-text"><strong>Cantidad:</strong> <?= $producto['cantidad'] ?></p>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="common-text">No tienes pedidos registrados.</p>
            <?php endif; ?>

        </div>

        <div class="cta-catalogue">
            <a href="../pages/catalogue.php" class="cta-btn">Hacer nuevo pedido</a>
        </div>
    </main>
</body>

</html>