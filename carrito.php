<?php
session_start();
include_once('conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "No estás logueado.";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT p.id_pedido AS id_pedido,
                               pr.nombre_prod AS producto_nombre,
                               pr.precio AS producto_precio,
                               pr.imagen AS producto_imagen,
                               pm.precio_personalizacion AS personalizacion_precio,
                               m.nombre_masa AS masa,
                               d.nombre_decoracion AS decoracion
                        FROM pedidos p
                        LEFT JOIN productos pr ON p.producto_id = pr.id_prod
                        LEFT JOIN personalizacion pm ON p.personalizacion_id = pm.id_personalizacion
                        LEFT JOIN masa m ON pm.masa_personalizacion = m.id_masa
                        LEFT JOIN decoracion d ON pm.decoracion_personalizacion = d.id_decoracion
                        WHERE p.usuario_pedido = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preload" href="css/estilos-comunes.css" as="style" />
    <link href="css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="css/carrito.css" as="style" />
    <link href="css/carrito.css" rel="stylesheet" />
</head>

<body>
    <h2 class="title">Tu Carrito</h2>
    <div class="carrito">
        <?php
        $total = 0;

        if ($result && $result->num_rows > 0) {
            while ($pedido = $result->fetch_assoc()) {
                echo '<div class="producto">';

                if (!empty($pedido['producto_nombre'])) {
                    echo '<img src="' . $pedido['producto_imagen'] . '" alt="' . $pedido['producto_nombre'] . '">';
                    echo '<div class="info">';
                    echo '<span>' . $pedido['producto_nombre'] . '</span>';
                    echo '<span class="precio">€' . number_format($pedido['producto_precio'], 2) . '</span>';
                    echo '</div>';
                    echo '<span>Cantidad: 1</span>';
                    $total += $pedido['producto_precio'];
                } else {
                    echo '<img src="ruta/img/personalizado.jpg" alt="Personalizado">';
                    echo '<div class="info">';
                    echo '<span>Personalizado</span>';
                    echo '<span>Masa: ' . $pedido['masa'] . ' | Decoración: ' . $pedido['decoracion'] . '</span>';
                    echo '<span class="precio">€' . number_format($pedido['personalizacion_precio'], 2) . '</span>';
                    echo '</div>';
                    echo '<span>Cantidad: 1</span>';
                    $total += $pedido['personalizacion_precio'];
                }

                echo '</div>';
            }

            echo '<div class="total">Total: €' . number_format($total, 2) . '</div>';
        } else {
            echo '<p>No hay productos en el carrito.</p>';
        }
        ?>
    </div>


</body>

</html>