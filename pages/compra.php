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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/compra.css" as="style" />
    <link href="../css/compra.css" rel="stylesheet" />
</head>

<body>

    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <section class="main">
        <div class="container-info">
            <div class="card-wrapper-single">
                <div class="card-1 card-object card-object-hf">
                    <a class="face front" href="#" style="background-image: url(<?php echo htmlspecialchars($producto['imagen']); ?>);">
                        <div class="title-wrapper">
                        </div>
                    </a>
                </div>
            </div>
            <div class="content-info">
                <h1 class="title categoria_nombre"><?php echo htmlspecialchars($producto['nombre_categ']); ?></h1>
                <h1 class="title nombre_prod"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h1>


                <!-- mantiene el formato del texto de la base de datos -->
                <p class="descripcion"><?php echo nl2br(htmlspecialchars($producto['descripcion_detallada_prod'])); ?></p>

                <h1><?php echo htmlspecialchars($producto['precio']); ?> €</h1>

                <!-- Aquí añadimos un data-attribute para pasar la información de sesión al JavaScript -->
                <div id="user-session" data-logged-in="<?php echo $isLoggedIn; ?>"></div>
                <div class="btn-compra"> <a class="cta-btn" id="add-to-cart" data-id="<?php echo $id; ?>">Añadir al carrito</a>
                    <a class="cta-btn" id="add-to-cart" data-id="<?php echo $id; ?>">Donar
                        <img src='../assets/img/icons/donation.png' alt='Icono de donaciones' class='icono'>
                    </a>
                </div>

            </div>
        </div>

        <div class="line"></div>


        <!-- CARDS -->
        <?php
        $sql = "SELECT id_categ, nombre_categ, descripcion_categ FROM categorias";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="cards-container">';
            echo '<div class="cards-title">
                <h1 class="subtitle-text title-info"> Ver más productos</h1>
            </div>';
            echo '<div class="cards-wrapper">';

            // Recorre cada producto y genera una card
            while ($row = $result->fetch_assoc()) {
                $nombre_categ = $row['nombre_categ'];
                $descripcion_categ = $row['descripcion_categ'];

                echo '<div class="card-wrapper">
                    <div class="card-' . htmlspecialchars($row['id_categ']) . ' card-object card-object-hf">
                        <a class="face front" href="catalogue.php#">
                            <div class="title-wrapper">
                                <div class="card-font">' . htmlspecialchars($nombre_categ) . '</div>
                                <div class="card-font-text">' . htmlspecialchars($descripcion_categ) . '</div>
                            </div>
                        </a>
                    </div>
                    
                </div>';
            }

            echo '</div>';
            echo '<div class="cta-catalogue">
                <a class="cta-btn" href="../pages/catalogue.php">
                    Ver catálogo completo
                </a>
            </div>
            </div>';
        } else {
            echo "No hay productos disponibles.";
        }
        ?>

        <?php
        echo $Footer
        ?>
    </section>

    <script src="../js/compra.js"></script>
</body>

</html>