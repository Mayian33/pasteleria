<?php
include_once('../php/layout.php');

// Verifica si el usuario es administrador con rol 1
$isAdmin = isset($_SESSION['rol']) && $_SESSION['rol'] == 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Catálogo</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/catalogue.css" as="style" />
    <link href="../css/catalogue.css" rel="stylesheet" />
</head>

<body>
    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <!-- Sección catálogo -->
    <section id="catalogo" class="main">
        <div class="container-catalogue">
            <h1 class="subtitle-text title-info">Catálogo de Productos <span>Caseros</span></h1>
        </div>

        <div class="cta-catalogue btn-wrapper">
            <?php
            if ($isAdmin) {
                echo "<a class='cta-btn btn-anadir' href='../pages/anadir.php'>Añadir más productos</a>";
            } else {
                echo "<a class='cta-btn common-text' href='../pages/personalization.php'>Personalización</a>";
                echo "   <a class='cta-btn common-text donation' href='../pages/donacion.php'>
                Donaciones
                <img src='../assets/img/icons/donation.png' alt='Icono de donaciones' class='icono'>
            </a>";
            }
            ?>

        </div>

        <div class="cards-wrapper">
            <?php
            $sql = "SELECT id_prod, nombre_prod, descripcion_prod, categoria, precio, imagen FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $productosPorCategoria = [];

                $categorias = [
                    '1' => 'tartas',
                    '2' => 'bizcochos',
                    '3' => 'ponches'
                ];

                while ($row = $result->fetch_assoc()) {
                    $categoriaNum = $row['categoria'];
                    if (isset($categorias[$categoriaNum])) {
                        $categoriaTexto = $categorias[$categoriaNum];
                    } else {
                        $categoriaTexto = 'otra';
                    }

                    if (!isset($productosPorCategoria[$categoriaTexto])) {
                        $productosPorCategoria[$categoriaTexto] = [];
                    }
                    $productosPorCategoria[$categoriaTexto][] = $row;
                }

                foreach ($productosPorCategoria as $categoria => $productos) {
                    echo "<div id='" . $categoria . "' class='categoria-container' style='scroll-margin-top: 80px;'>";
                    echo "<div class='cards-title'>";
                    echo "<h2 class='subtitle-text title-info categoria-titulo'>" . ucfirst($categoria) . "</h2>";
                    echo "</div>";
                    echo "<div class='productos'>"; // Inicio del contenedor de productos
                    foreach ($productos as $producto) {
                        echo "<div class='card-wrapper'>"; // INICIO card-wrapper

                        echo "<div class='card-1 card-object card-object-hf'>"; // INICIO card-object

                        // CARA FRONTAL
                        echo "<a class='face front' href='../pages/compra.php?id=" . htmlspecialchars($producto['id_prod']) . "' style='background-image: url(" . htmlspecialchars($producto['imagen']) . ");'>";
                        echo "<div class='title-wrapper'>";
                        echo "<div class='card-font'>" . htmlspecialchars($producto['nombre_prod']) . "</div>";
                        echo "<div class='card-font-text'>" . htmlspecialchars($producto['descripcion_prod']) . "</div>";
                        echo "</div>";
                        echo "</a>";

                        // CARA TRASERA (puedes mantenerla o quitarla si no la usas mucho)
                        echo "<a class='face back' href='#'>";
                        echo "<div class='img-wrapper'>";
                        echo "<div class='avatar' style='background-image: url(" . htmlspecialchars($producto['imagen']) . ");'></div>";
                        echo "</div>";
                        echo "</a>";

                        echo "</div>"; // FIN card-object

                        // METEMOS AQUÍ los botones de editar/borrar
                        if ($isAdmin) {
                            echo "<div class='edit-button-container'>";
                            echo "<a href='../pages/editar.php?id=" . htmlspecialchars($producto['id_prod']) . "' class='btn-editar cta-btn'>Editar</a>";
                            echo "<a href='../php/borrarProducto.php?id=" . htmlspecialchars($producto['id_prod']) . "' class='btn-borrar'>Borrar</a>";
                            echo "</div>";
                        }

                        echo "</div>"; // FIN card-wrapper

                    }
                    echo "</div>"; // Fin del contenedor de productos

                    echo "</div>"; // Fin de la categoría
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            $conn->close();
            ?>
        </div>
        <?php
        echo $Footer
        ?>
    </section>

    <script>
        window.addEventListener('load', () => {
            const hash = window.location.hash;
            if (hash) {
                const el = document.querySelector(hash);
                if (el) {
                    setTimeout(() => {
                        el.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }, 100);
                }
            }
        });
    </script>
</body>

</html>