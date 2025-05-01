<?php
session_start();
include_once('../php/conexion.php');

if (!isset($_SESSION['usuario_id'])) {  // Usamos 'usuario_id' en vez de 'id_usuario'
    echo "<script>alert('Por favor, inicia sesión para ver tu carrito.'); window.location.href='../pages/compra.php';</script>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];  // Usamos 'usuario_id' aquí también


$stmt = $conn->prepare("SELECT c.id_carrito AS id_carrito,
                               pr.nombre_prod AS producto_nombre,
                               pr.precio AS producto_precio,
                               pr.imagen AS producto_imagen,
                               pm.precio_personalizacion AS personalizacion_precio,
                               pm.imagen_personalizacion AS imagen_personalizacion,
                               s.nombre_sabor AS sabor,
                               t.nombre_tamano AS tamano,
                               m.nombre_masa AS masa,
                               d.nombre_decoracion AS decoracion
                        FROM carrito c
                        LEFT JOIN productos pr ON c.producto_id = pr.id_prod
                        LEFT JOIN personalizacion pm ON c.personalizacion_id = pm.id_personalizacion
                        LEFT JOIN sabor s ON pm.sabor_personalizacion = s.id_sabor
                        LEFT JOIN tamano t ON pm.tamano_personalizacion = t.id_tamano
                        LEFT JOIN masa m ON pm.masa_personalizacion = m.id_masa
                        LEFT JOIN decoracion d ON pm.decoracion_personalizacion = d.id_decoracion
                        WHERE c.usuario_carrito = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/carrito.css" as="style" />
    <link href="../css/carrito.css" rel="stylesheet" />
</head>

<body>

    <header>
        <?php echo $Menu ?>
    </header>

    <h2 class="title">Tu Carrito</h2>
    <div class="carrito">

        <div>
            <a class="cta-btn" href="../pages/pedidos.php">Ver mis pedidos</a>
        </div>

        <?php
        $total = 0;

        if ($result && $result->num_rows > 0) {
            while ($carrito = $result->fetch_assoc()) {
                echo '<div class="producto">';

                if (!empty($carrito['producto_nombre'])) {
                    echo '<img src="' . $carrito['producto_imagen'] . '" alt="' . $carrito['producto_nombre'] . '">';
                    echo '<div class="info">';
                    echo '<span>' . $carrito['producto_nombre'] . '</span>';
                    echo '<span class="precio">€' . number_format($carrito['producto_precio'], 2) . '</span>';
                    echo '</div>';
                    echo '
                    <div class="cantidad">
                        <button onclick="cambiarCantidad(this, -1)">−</button>
                        <span class="cantidad-numero">1</span>
                        <input type="hidden" value="1">
                        <button onclick="cambiarCantidad(this, 1)">+</button>
                        <form method="POST" action="../php/eliminar_carrito.php" onsubmit="return confirm(\'¿Eliminar este producto?\');">
                            <input type="hidden" name="id_carrito" value="' . $carrito['id_carrito'] . '">
                            <button type="submit" class="papelera">🗑️</button>
                        </form>
                    </div>';

                    $total += $carrito['producto_precio'];
                } else {
                    echo '<img src="' . $carrito['imagen_personalizacion'] . '" alt="Personalizado">';
                    echo '<div class="info">';
                    echo '<span>Personalizado</span>';
                    echo '<span>Sabor: ' . $carrito['sabor'] . ' | Masa: ' . $carrito['masa'] . ' | Tamaño: ' . $carrito['tamano'] . ' | Decoración: ' . $carrito['decoracion'] . '</span>';
                    echo '<span class="precio">€' . number_format($carrito['personalizacion_precio'], 2) . '</span>';
                    echo '</div>';
                    echo '
                    <div class="cantidad">
                        <button onclick="cambiarCantidad(this, -1)">−</button>
                        <span class="cantidad-numero">1</span>
                        <input type="hidden" value="1">
                        <button onclick="cambiarCantidad(this, 1)">+</button>
                        <form method="POST" action="../php/eliminar_carrito.php" onsubmit="return confirm(\'¿Eliminar este producto?\');">
                            <input type="hidden" name="id_carrito" value="' . $carrito['id_carrito'] . '">
                            <button type="submit" class="papelera">🗑️</button>
                        </form>
                    </div>';;
                    $total += $carrito['personalizacion_precio'];
                }

                echo '</div>';
            }

            echo '<div class="total">Total: €' . number_format($total, 2) . '</div>';
        } else {
            echo '<p>No hay productos en el carrito.</p>';
        }
        ?>
    </div>

    <script src="../js/carrito.js"></script>

</body>

</html>