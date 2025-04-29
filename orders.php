<?php
session_start();

// Solo permitir acceso a administradores (rol 1)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: index.php");
    exit();
}

include_once 'conexion.php';

$sql = "SELECT 
    p.id_pedido, 
    p.usuario_pedido,
    p.fecha_pedido,
    p.total,
    u.nombre_usuario, 
    prod.nombre_prod,
    pers.sabor_personalizacion,
    c.nombre_categ
FROM pedidos p
LEFT JOIN usuarios u ON p.usuario_pedido = u.id_usuario
LEFT JOIN productos prod ON p.producto_id = prod.id_prod
LEFT JOIN personalizacion pers ON p.personalizacion_id = pers.id_personalizacion
LEFT JOIN categorias c ON prod.categoria = c.id_categ
ORDER BY p.usuario_pedido, p.fecha_pedido DESC"; // Ordenamos por usuario y luego por fecha

$result = $conn->query($sql);

// Agrupar los pedidos por usuario
$pedidos_por_usuario = [];
while ($row = $result->fetch_assoc()) {
    $pedidos_por_usuario[$row['usuario_pedido']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pedidos | Admin</title>
    <link rel="preload" href="css/estilos-comunes.css" as="style" />
    <link href="css/estilos-comunes.css" rel="stylesheet" />
</head>

<body>

    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <div class="main">
        <h1 class="title">Pedidos Recibidos</h1>
        <div class="pedidos">
            <?php if (!empty($pedidos_por_usuario)): ?>
                <?php foreach ($pedidos_por_usuario as $usuario_id => $pedidos): ?>
                    <div class="usuario-pedidos">
                        <h2 class="regular-title">Pedidos de: <?= htmlspecialchars($pedidos[0]['nombre_usuario']) ?></h2>
                        <?php foreach ($pedidos as $row): ?>
                            <div class="pedido-card">
                                <br>
                                <p class="common-text"><strong>Fecha:</strong> <?= $row['fecha_pedido'] ?></p>
                                <p class="common-text">
                                    <strong>Producto:</strong>
                                    <?php
                                    if (!empty($row['nombre_prod'])) {
                                        echo htmlspecialchars($row['nombre_prod']) . ' (' . htmlspecialchars($row['nombre_categ']) . ')';
                                    } elseif (!empty($row['sabor_personalizacion'])) {
                                        echo 'Personalizado - ' . htmlspecialchars($row['sabor_personalizacion']);
                                    } else {
                                        echo 'Producto desconocido';
                                    }
                                    ?>
                                </p>
                                <p class="common-text"><strong>Total:</strong> <?= $row['total'] ?> €</p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="common-text">No hay pedidos registrados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>