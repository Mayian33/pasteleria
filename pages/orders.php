<?php
session_start();

// Solo permitir acceso a administradores (rol 1)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: index.php");
    exit();
}

include_once('../php/conexion.php');

$sql = "SELECT 
    cr.id_carrito,
    cr.usuario_carrito,
    cr.fecha_carrito,
    u.nombre_usuario,
    u.telefono_usuario,
    u.direccion_usuario,
    u.email_usuario,
    prod.nombre_prod,
    prod.precio,
    pers.sabor_personalizacion,
    c.nombre_categ,
    e.nombre_estado,
    p.pedido_id,
    e.id_estado

FROM carrito cr
LEFT JOIN usuarios u ON cr.usuario_carrito = u.id_usuario
LEFT JOIN productos prod ON cr.producto_id = prod.id_prod
LEFT JOIN personalizacion pers ON cr.personalizacion_id = pers.id_personalizacion
LEFT JOIN categorias c ON prod.categoria = c.id_categ
LEFT JOIN detalle_pedido dp ON dp.producto = cr.producto_id
LEFT JOIN pedidos p ON dp.pedido = p.pedido_id AND p.usuario_id = cr.usuario_carrito
LEFT JOIN estados e ON p.estado_pedido = e.id_estado
ORDER BY cr.usuario_carrito, cr.fecha_carrito DESC;
";


$result = $conn->query($sql);

// Cargar los estados para el dropdown
$estadosQuery = $conn->query("SELECT id_estado, nombre_estado FROM estados");
$estados = $estadosQuery->fetch_all(MYSQLI_ASSOC);


// Agrupar los pedidos por usuario
$carrito_por_usuario = [];
while ($row = $result->fetch_assoc()) {
    $carrito_por_usuario[$row['usuario_carrito']][] = $row;
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
        alert(data); // Reemplaza esto si prefieres mostrar el mensaje dentro del formulario
    })
    .catch(error => {
        console.error('Error al actualizar el estado:', error);
    });
}
</script>



    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <div class="main">
        <h1 class="title">Pedidos Recibidos</h1>
        <div class="pedidos">
            <?php if (!empty($carrito_por_usuario)): ?>
                <?php foreach ($carrito_por_usuario as $usuario_id => $carrito): ?>
                    <div class="usuario-pedidos">
                        <h2 class="regular-title title-info">Pedidos de: <?= htmlspecialchars($carrito[0]['nombre_usuario']) ?></h2>

                        <!-- Nueva info del usuario -->
                        <p class="common-text"><strong>Email:</strong> <?= htmlspecialchars($carrito[0]['email_usuario'] ?? 'No disponible') ?></p>
                        <p class="common-text"><strong>Teléfono:</strong> <?= htmlspecialchars($carrito[0]['telefono_usuario'] ?? 'No disponible') ?></p>
                        <p class="common-text"><strong>Dirección:</strong> <?= htmlspecialchars($carrito[0]['direccion_usuario'] ?? 'No disponible') ?></p>

                        <?php foreach ($carrito as $row): ?>
                            <div class="pedido-card">
                                <br>
                                <p class="common-text"><strong>Fecha:</strong> <?= $row['fecha_carrito'] ?></p>
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
                                <p class="common-text">
                                    <strong>Total:</strong>
                                    <?php
                                    if (!empty($row['nombre_prod'])) {
                                        echo number_format($row['precio'], 2) . ' €';
                                    } elseif (!empty($row['sabor_personalizacion'])) {
                                        echo number_format($row['total_carrito'], 2) . ' €';
                                    } else {
                                        echo '0.00 €';
                                    }
                                    ?>
                                </p>

                                <form onsubmit="guardarEstado(event, <?= $row['pedido_id'] ?>)">
                                    <select name="estado" class="custom-dropdown">
                                        <option value="" disabled selected>Estado por defecto</option>
                                        <?php foreach ($estados as $estado): ?>
                                            <option value="<?= $estado['id_estado'] ?>" <?= $row['id_estado'] == $estado['id_estado'] ? 'selected' : '' ?>>
                                                <?= $estado['nombre_estado'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="guardar-btn cta-btn">Guardar</button>
                                </form>



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