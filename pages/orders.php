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

$sql_donaciones = "SELECT d.*, u.nombre_usuario, p.nombre_prod
                   FROM donacion d
                   JOIN usuarios u ON d.usuario_donacion = u.id_usuario
                   JOIN productos p ON d.producto_donacion = p.id_prod
                   ORDER BY d.fecha_donacion DESC";

$result_don = $conn->query($sql_donaciones);

$donaciones = [];
while ($row = $result_don->fetch_assoc()) {
    $donaciones[] = $row;
}

$donaciones_por_usuario = [];
foreach ($donaciones as $don) {
    $donaciones_por_usuario[$don['usuario_donacion']][] = $don;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="btn-save"><button type="submit" class="guardar-btn cta-btn common-text">Guardar cambios</button></div>
            <?php
            $eventos = [];

            // Añadir pedidos
            foreach ($pedidos_por_usuario as $usuario_id => $pedidos) {
                // Agrupar pedidos por pedido_id
                $pedidos_agrupados = [];
                foreach ($pedidos as $pedido) {
                    $pedidos_agrupados[$pedido['pedido_id']][] = $pedido;
                }

                foreach ($pedidos_agrupados as $pedido_id => $detalles) {
                    $eventos[] = [
                        'tipo' => 'pedido',
                        'usuario_id' => $usuario_id,
                        'pedido_id' => $pedido_id,
                        'fecha' => $detalles[0]['fecha_pedido'],
                        'detalles' => $detalles
                    ];
                }
            }

            // Añadir donaciones
            foreach ($donaciones as $don) {
                $eventos[] = [
                    'tipo' => 'donacion',
                    'usuario_id' => $don['usuario_donacion'],
                    'fecha' => $don['fecha_donacion'],
                    'donacion' => $don
                ];
            }

            // Ordenar por fecha DESC
            usort($eventos, function ($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });

            $eventos_por_usuario = [];

            foreach ($eventos as $evento) {
                $usuario_id = $evento['usuario_id'];
                $eventos_por_usuario[$usuario_id][] = $evento;
            }

            ?>


            <div class="pedidos">
                <?php foreach ($eventos_por_usuario as $usuario_id => $eventos_usuario): ?>
                    <div class="usuario-pedidos">
                        <h2 class="regular-title title-info">Usuario: <?= htmlspecialchars(
                                                                            $eventos_usuario[0]['tipo'] === 'pedido'
                                                                                ? $eventos_usuario[0]['detalles'][0]['nombre_pedido']
                                                                                : $eventos_usuario[0]['donacion']['nombre_usuario']
                                                                        ) ?></h2>

                        <?php foreach ($eventos_usuario as $evento): ?>
                            <?php if ($evento['tipo'] === 'pedido'): ?>
                                <?php $detalles = $evento['detalles']; ?>
                                <div class="pedido-card">
                                    <p class="common-text"><strong>Fecha:</strong> <?= $evento['fecha'] ?></p>

                                    <select name="estado_<?= $evento['pedido_id'] ?>" class="custom-dropdown">
                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= $estado['id_estado'] ?>" <?= $detalles[0]['estado_pedido'] == $estado['id_estado'] ? 'selected' : '' ?>>
                                                <?= $estado['nombre_estado'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <?php foreach ($detalles as $row): ?>
                                        <div class="producto-box">
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
                                            <?php endif; ?>
                                            <p class="common-text"><strong>Cantidad:</strong> <?= $row['cantidad'] ?></p>
                                            <p class="common-text"><strong>Precio unitario:</strong> <?= number_format($row['total_pedido'], 2) ?> €</p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif ($evento['tipo'] === 'donacion'): ?>
                                <?php $don = $evento['donacion']; ?>
                                <div class="pedido-card">
                                    <p class="common-text"><strong>🩷 Donación solidaria</strong></p>

                                    

                                    <p class="common-text"><strong>Fecha:</strong> <?= $don['fecha_donacion'] ?></p>
                                    <p class="common-text"><strong>Producto donado:</strong> <?= htmlspecialchars($don['nombre_prod']) ?></p>
                                    <p class="common-text"><strong>Monto:</strong> <?= number_format($don['monto_donacion'], 2) ?> €</p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>



            <?php if (empty($eventos)): ?>
                <p class="common-text">No hay pedidos ni donaciones registradas.</p>
            <?php endif; ?>





            <div style="text-align:center; margin-top:2rem;">

            </div>
        </form>

    </div>
</body>

</html>