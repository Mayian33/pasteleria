<?php
session_start();
include_once('../php/layout.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Por favor, inicia sesión para ver tu carrito.'); window.location.href='../pages/compra.php';</script>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener opciones adicionales agrupadas por id_personalizacion
$opciones_personalizadas = [];

$sql_opciones = "SELECT oa.id_personalizacion AS id_personalizacion_opcion, o.nombre_opcion
                 FROM opciones_adicionales oa
                 JOIN opciones o ON oa.id_opcion = o.opcion_id";
$result_opciones = $conn->query($sql_opciones);

if ($result_opciones && $result_opciones->num_rows > 0) {
    while ($fila = $result_opciones->fetch_assoc()) {
        $opciones_personalizadas[$fila['id_personalizacion_opcion']][] = $fila['nombre_opcion'];
    }
}

// Consulta principal del carrito
$stmt = $conn->prepare("SELECT c.id_carrito AS id_carrito,
                               pr.nombre_prod AS producto_nombre,
                               pr.precio AS producto_precio,
                               pr.imagen AS producto_imagen,
                               pm.id_personalizacion AS personalizacion_id, -- añadido
                               pm.precio_personalizacion AS personalizacion_precio,
                               pm.imagen_personalizacion AS imagen_personalizacion,
                               s.nombre_sabor AS sabor,
                               t.nombre_tamano AS tamano,
                               m.nombre_masa AS masa,
                               d.nombre_decoracion AS decoracion,
                               cat.nombre_categ AS categoria
                        FROM carrito c
                        LEFT JOIN productos pr ON c.producto_id = pr.id_prod
                        LEFT JOIN categorias cat ON pr.categoria = cat.id_categ
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
<html lang="es">

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

    <div class="container-title">
        <h2 class="title">Tu Carrito</h2>
        <div class="botons">
            <a class="cta-btn" href="../pages/payedOrders.php">Ver mis pedidos</a>
            <a class="cta-btn" href="../pages/catalogue.php">Ver catálogo</a>
        </div>
    </div>

    <div class="carrito">
        <?php
        $total = 0;
        echo '<div class="common-text">';
        if ($result && $result->num_rows > 0) {
            while ($carrito = $result->fetch_assoc()) {
                echo '<div class="producto">';

                if (!empty($carrito['producto_nombre'])) {
                    echo '<img src="' . $carrito['producto_imagen'] . '" alt="' . $carrito['producto_nombre'] . '">';
                    echo '<div class="info">';
                    $categoria = ucfirst(strtolower($carrito['categoria'] ?? 'Producto'));
                    $nombre = ucfirst(strtolower($carrito['producto_nombre']));
                    echo '<span>' . $categoria . ' ' . $nombre . '</span>';
                    echo '<span>Sabor: ' . $carrito['sabor'] . ' | Masa: ' . $carrito['masa'] . ' | Tamaño: ' . $carrito['tamano'] . ' | Decoración: ' . $carrito['decoracion'] . '</span>';
                    echo '<span class="precio">€' . number_format($carrito['producto_precio'], 2) . '</span>';
                    echo '</div>';

                    $cantidad = isset($_SESSION['carrito'][$carrito['id_carrito']]['cantidad']) ? $_SESSION['carrito'][$carrito['id_carrito']]['cantidad'] : 1;

                    echo '
                <div class="cantidad" data-id="' . $carrito['id_carrito'] . '">
                    <button class="restar" type="button">−</button>
                    <span class="cantidad-numero">' . $cantidad . '</span>
                    <input type="hidden" value="' . $cantidad . '">
                    <button class="sumar" type="button">+</button>
                    <form method="POST" action="../php/eliminar_carrito.php" onsubmit="return confirm(\'¿Eliminar este producto?\');">
                        <input type="hidden" name="id_carrito" value="' . $carrito['id_carrito'] . '">
                        <button type="submit" class="papelera"><img src="../assets/img/icons/trash.svg" alt="Eliminar"></button>
                    </form>
                </div>';

                    $total += $carrito['producto_precio'];
                } elseif (!empty($carrito['personalizacion_precio'])) {
                    echo '<img src="' . $carrito['imagen_personalizacion'] . '" alt="Personalizado">';
                    echo '<div class="info">';
                    echo '<span>Personalizado</span>';
                    echo '<span>Sabor: ' . $carrito['sabor'] . ' | Masa: ' . $carrito['masa'] . ' | Tamaño: ' . $carrito['tamano'] . ' | Decoración: ' . $carrito['decoracion'] . '</span>';

                    $id_personalizacion = $carrito['personalizacion_id'];
                    if (isset($opciones_personalizadas[$id_personalizacion])) {
                        echo '<span>Opciones adicionales: ' . implode(', ', $opciones_personalizadas[$id_personalizacion]) . '</span>';
                    }

                    echo '<span class="precio">€' . number_format($carrito['personalizacion_precio'] ?? 0, 2) . '</span>';
                    echo '</div>';

                    $cantidad = isset($_SESSION['carrito'][$carrito['id_carrito']]['cantidad']) ? $_SESSION['carrito'][$carrito['id_carrito']]['cantidad'] : 1;

                    echo '
                <div class="cantidad" data-id="' . $carrito['id_carrito'] . '">
                    <button class="restar" type="button">−</button>
                    <span class="cantidad-numero">' . $cantidad . '</span>
                    <input type="hidden" value="' . $cantidad . '">
                    <button class="sumar" type="button">+</button>
                    <form method="POST" action="../php/eliminar_carrito.php" onsubmit="return confirm(\'¿Eliminar este producto?\');">
                        <input type="hidden" name="id_carrito" value="' . $carrito['id_carrito'] . '">
                        <button type="submit" class="papelera"><img src="../assets/img/icons/trash.svg" alt="Eliminar"></button>
                    </form>
                </div>';

                    $total += $carrito['personalizacion_precio'] ?? 0;
                }

                echo '</div>';
            }

            echo '<div class="total">Total: €' . number_format($total, 2) . '</div>';
        } else {
            echo '<p>No hay productos en el carrito.</p>';
        }
        echo '</div>';
        ?>
        <button id="mostrar-formulario" class="cta-btn common-text  btn-carrito">Realizar pedido</button>

        <div id="formulario-pedido" style="display:none; margin-top:20px;">
            <form method="POST" action="../pages/stripe/checkout.php" class="formulario-envio">
                <label class="common-text">
                    Nombre completo:
                    <input type="text" name="nombre" required>
                </label>

                <label class="common-text">
                    Email:
                    <input type="email" name="email" required>
                </label>

                <label class="common-text">
                    Teléfono:
                    <input type="tel" name="telefono" required pattern="[0-9]{9}" title="Introduce un número válido">
                </label>

                <label class="common-text">
                    Dirección:
                    <input type="text" name="direccion" required placeholder="Calle, número, piso...">
                </label>

                <label class="common-text">
                    Ciudad:
                    <input type="text" name="ciudad" required>
                </label>

                <label class="common-text">
                    Código postal:
                    <input type="text" name="cp" required pattern="[0-9]{5}" title="Introduce un CP válido">
                </label>
                <button type="submit" class="cta-btn common-text btn-carrito">Pagar</button>
            </form>

        </div>

    </div>
    <script>
        document.getElementById('mostrar-formulario').addEventListener('click', function() {
            const productos = document.querySelectorAll('.producto');

            if (productos.length === 0) {
                alert('Tu carrito está vacío. Añade productos antes de realizar un pedido.');
                return;
            }

            document.getElementById('formulario-pedido').style.display = 'block';
            this.style.display = 'none';
        });
    </script>


    <script src="../js/carrito.js"></script>

</body>

</html>