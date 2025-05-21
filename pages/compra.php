<?php
session_start();
include_once('../php/layout.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consulta para obtener la información del producto
    $sql = "SELECT p.*, c.nombre_categ 
            FROM productos p
            LEFT JOIN categorias c ON p.categoria = c.id_categ
            WHERE p.id_prod = $id";

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID no proporcionado.";
    exit;
}

// Verifica si el usuario está logueado
$isLoggedIn = isset($_SESSION['usuario_id']) ? 'true' : 'false';

// Capturar mensaje de error
$mensaje_error = '';
if (isset($_GET['error']) && $_GET['error'] === 'duplicado') {
    $mensaje_error = 'Este producto ya está en tu carrito. Puedes ajustar la cantidad desde allí.';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />
    <link rel="preload" href="../css/compra.css" as="style" />
    <link href="../css/compra.css" rel="stylesheet" />

    <style>
        .alerta-error {
            background-color: #ffd2d2;
            border: 1px solid #ff0000;
            color: #a70000;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <?php echo $Menu ?>
    </header>

    <section class="main">
        <div class="container-info">
            <div class="card-wrapper-single">
                <div class="card-1 card-object card-object-hf">
                    <a class="face front" href="#" style="background-image: url(<?php echo htmlspecialchars($producto['imagen']); ?>);">
                        <div class="title-wrapper"></div>
                    </a>
                </div>
            </div>
            <div class="content-info">
                <h1 class="title categoria_nombre"><?php echo htmlspecialchars($producto['nombre_categ']); ?></h1>
                <h1 class="title nombre_prod"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h1>
                <p class="descripcion"><?php echo nl2br(htmlspecialchars($producto['descripcion_detallada_prod'])); ?></p>
                <h1><?php echo htmlspecialchars($producto['precio']); ?> €</h1>

                <?php if (!empty($mensaje_error)) : ?>
                    <div class="alerta-error">
                        <?php echo $mensaje_error; ?>
                    </div>
                <?php endif; ?>

                <div id="user-session" data-logged-in="<?php echo $isLoggedIn; ?>"></div>
                <div class="btn-compra">
  <button id="add-to-cart" data-id="<?= $producto['id_prod']; ?>">Añadir al carrito</button>

<!-- Mensaje visual que mostrará el resultado -->
<div id="mensaje-usuario" class="mensaje-usuario" style="display:none;"></div>



                    <a class="cta-btn" href="../php/carritoInsert.php?id=<?php echo $id; ?>">Donar
                        <img src='../assets/img/icons/donation.png' alt='Icono de donaciones' class='icono'>
                    </a>
                </div>
            </div>
        </div>

        <div class="line"></div>

        <?php
        $sql = "SELECT id_categ, nombre_categ, descripcion_categ FROM categorias";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="cards-container">';
            echo '<div class="cards-title"><h1 class="subtitle-text title-info"> Ver más productos</h1></div>';
            echo '<div class="cards-wrapper">';

            while ($row = $result->fetch_assoc()) {
                echo '<div class="card-wrapper">
                        <div class="card-' . htmlspecialchars($row['id_categ']) . ' card-object card-object-hf">
                            <a class="face front" href="catalogue.php#">
                                <div class="title-wrapper">
                                    <div class="card-font">' . htmlspecialchars($row['nombre_categ']) . '</div>
                                    <div class="card-font-text">' . htmlspecialchars($row['descripcion_categ']) . '</div>
                                </div>
                            </a>
                        </div>
                      </div>';
            }

            echo '</div>
                <div class="cta-catalogue">
                    <a class="cta-btn" href="../pages/catalogue.php">Ver catálogo completo</a>
                </div>
              </div>';
        } else {
            echo "No hay productos disponibles.";
        }

        echo $Footer;
        ?>
    </section>

    <script src="../js/compra.js"></script>
</body>

</html>
