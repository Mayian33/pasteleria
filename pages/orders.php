<?php
session_start();

// Solo permitir acceso a administradores (rol 1)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: index.php");
    exit();
}
include_once('../php/layout.php');

// Consulta principal
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

WHERE p.estado_pedido != 5

ORDER BY p.fecha_pedido DESC";




$result = $conn->query($sql);

// Cargar los estados para el dropdown
$estadosQuery = $conn->query("SELECT id_estado, nombre_estado FROM estados");
$estados = $estadosQuery->fetch_all(MYSQLI_ASSOC);

// Agrupar los pedidos por usuario
$pedidos_por_usuario = [];
while ($row = $result->fetch_assoc()) {
    $pedidos_por_usuario[$row['usuario_id']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Pedidos | Admin</title>
    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />
    <link rel="preload" href="../css/orders.css" as="style" />
    <link href="../css/orders.css" rel="stylesheet" />
</head>

<body>

    <script>
        function guardarEstado(event, pedidoId) {
            event.preventDefault();

            const form = event.target;
            const estado = form.querySelector('select[name="estado"]').value;

            fetch('../php/actualizar_estado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `pedido_id=${pedidoId}&estado_id=${estado}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                })
                .catch(error => {
                    console.error('Error al actualizar el estado:', error);
                });
        }
    </script>

    <header>
        <?php echo $Menu ?>
    </header>

    <div class="main">
        <h1 class="title">Pedidos Recibidos</h1>


        <form method="POST" action="../php/actualizar_estado.php">
            <button type="submit" class="guardar-btn cta-btn common-text">Guardar cambios</button>
            <div class="pedidos">
                <?php if (!empty($pedidos_por_usuario)): ?>
                    <?php foreach ($pedidos_por_usuario as $usuario_id => $pedidos): ?>
                        <div class="usuario-pedidos">
                            <h2 class="regular-title title-info">Pedido de: <?= htmlspecialchars($pedidos[0]['nombre_pedido']) ?></h2>

                            <!-- Datos del cliente -->
                            <p class="common-text"><strong>Email:</strong> <?= htmlspecialchars($pedidos[0]['email_pedido']) ?></p>
                            <p class="common-text"><strong>Teléfono:</strong> <?= htmlspecialchars($pedidos[0]['telefono_pedido']) ?></p>
                            <p class="common-text"><strong>Dirección:</strong> <?= htmlspecialchars($pedidos[0]['direccion_pedido']) ?>, <?= htmlspecialchars($pedidos[0]['ciudad']) ?> (<?= htmlspecialchars($pedidos[0]['cp']) ?>)</p>

                            <?php foreach ($pedidos as $row): ?>
                                <div class="pedido-card">
                                    <p class="common-text"><strong>Fecha:</strong> <?= $row['fecha_pedido'] ?></p>

                                    <?php if (!empty($row['nombre_prod'])): ?>
                                        <p class="common-text"><strong>Producto:</strong> <?= htmlspecialchars($row['nombre_prod']) ?></p>

                                    <?php elseif (!empty($row['id_personalizacion'])): ?>
                                        <p class="common-text"><strong>Producto personalizado</strong></p>
                                        <ul class="common-text">
                                            <li><strong>Tamaño:</strong> <?= htmlspecialchars($row['nombre_tamano'] ?? 'No especificada') ?></li>
                                            <li><strong>Masa:</strong> <?= htmlspecialchars($row['nombre_masa'] ?? 'No especificada') ?></li>
                                            <li><strong>Sabor:</strong> <?= htmlspecialchars($row['nombre_sabor'] ?? 'No especificado') ?></li>
                                            <li><strong>Decoración:</strong> <?= htmlspecialchars($row['nombre_decoracion'] ?? 'No especificada') ?></li>
                                        </ul>

                                    <?php else: ?>
                                        <p class="common-text"><strong>Producto:</strong> Producto desconocido</p>
                                    <?php endif; ?>




                                    <p class="common-text"><strong>Cantidad:</strong> <?= $row['cantidad'] ?></p>
                                    <p class="common-text"><strong>Precio unitario:</strong> <?= number_format($row['total_pedido'], 2) ?> €</p>

                                    <select name="estado_<?= $row['pedido_id'] ?>" class="custom-dropdown">

                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= $estado['id_estado'] ?>" <?= $row['estado_pedido'] == $estado['id_estado'] ? 'selected' : '' ?>>
                                                <?= $estado['nombre_estado'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>


                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="common-text">No hay pedidos registrados.</p>
                <?php endif; ?>
            </div>
            <div style="text-align:center; margin-top:2rem;">

            </div>
        </form>

    </div>
</body>

</html>