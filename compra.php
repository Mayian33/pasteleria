<?php
include_once('conexion.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consulta para obtener la información del producto
    $sql = "SELECT * FROM productos WHERE id_prod = $id";
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

    <link rel="preload" href="css/estilos-comunes.css" as="style" />
    <link href="css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="css/compra.css" as="style" />
    <link href="css/compra.css" rel="stylesheet" />
</head>

<body>

    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

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
            <h1 class="title"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h1>
            <p><?php echo htmlspecialchars($producto['descripcion_prod']); ?></p>
            <h1><?php echo htmlspecialchars($producto['precio']); ?> €</h1>

            <!-- Aquí añadimos un data-attribute para pasar la información de sesión al JavaScript -->
            <div id="user-session" data-logged-in="<?php echo $isLoggedIn; ?>"></div>
            <a class="cta-btn" id="add-to-cart" href="carritoInsert.php?id=<?php echo $id; ?>">Añadir al carrito</a>
        </div>
    </div>

    <hr>

    <!-- CARDS -->
    <?php
    $sql = "SELECT id_categ, nombre_categ, descripcion_categ FROM categorias";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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
                <a class="cta-btn" href="#">
                    Ver catálogo completo
                </a>
            </div>';
    } else {
        echo "No hay productos disponibles.";
    }
    ?>

    <!-- Modal de Login -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <h3 class="common-text">¡Oops!</h3>
            <p class="common-text">No estás logueado. ¿Quieres iniciar sesión?</p>
            <div class="modal-actions">
                <a class="cta-btn" id="go-to-login">Sí, iniciar sesión</a>
                <a class="cta-btn" id="cancel-login">No, gracias</a>
            </div>
        </div>
    </div>

    <script src="js/compra.js"></script>
</body>

</html>