<?php
include_once('../php/layout.php');
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

    <header>
        <?php echo $Menu ?>
    </header>

    <section id="catalogo" class="main">
        <div class="container-catalogue">
            <h1 class="subtitle-text title-info">Catálogo de Productos <span>Caseros</span></h1>
        </div>

        <div class="cta-catalogue btn-wrapper">
            <?php
            if ($isAdmin) {
                echo "<a class='cta-btn btn-anadir common-text' href='../pages/anadir.php'>Añadir más productos</a>";
            } else {
                echo "<a class='cta-btn common-text btn-perso' href='../pages/personalization.php'>Personaliza tu propia tarta</a>";
                echo "<a class='cta-btn common-text donation btn-perso' href='../pages/donacion.php'>
                    Donaciones <img src='../assets/img/icons/donation.png' alt='Donaciones' class='icono'>
                  </a>";
            }
            ?>
        </div>

        <div class="cards-wrapper">
            <?php
            $sql_categorias = "SELECT id_categ, nombre_categ FROM categorias";
            $result_categorias = $conn->query($sql_categorias);
            $categorias = [];

            while ($row = $result_categorias->fetch_assoc()) {
                $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $row['nombre_categ']))));
                $categorias[$row['id_categ']] = $slug;
            }

            $sql = "SELECT id_prod, nombre_prod, descripcion_prod, categoria, precio, imagen FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $productosPorCategoria = [];

                while ($row = $result->fetch_assoc()) {
                    $categoriaNum = $row['categoria'];
                    $categoriaTexto = $categorias[$categoriaNum] ?? 'otros';

                    if (!isset($productosPorCategoria[$categoriaTexto])) {
                        $productosPorCategoria[$categoriaTexto] = [];
                    }
                    $productosPorCategoria[$categoriaTexto][] = $row;
                }

                foreach ($productosPorCategoria as $categoria => $productos) {
                    echo "<div id='$categoria' class='categoria-container' >";
                    echo "<div class='cards-title'><h2 class='subtitle-text title-info categoria-titulo'>" . ucfirst($categoria) . "</h2></div>";
                    echo "<div class='productos'>";
                    foreach ($productos as $producto) {
                        echo "<div class='card-wrapper'>";
                        echo "<div class='card-visual'>";
                        echo "<div class='card-object'>";
                        if (!$isAdmin) {
                            echo "<a class='face front' href='../pages/compra.php?id=" . htmlspecialchars($producto['id_prod']) . "' style='background-image: url(" . htmlspecialchars($producto['imagen']) . ");'>";
                        } else {
                            echo "<div class='face front' style='background-image: url(" . htmlspecialchars($producto['imagen']) . "); cursor: default;'>";
                        }

                        echo "<div class='title-wrapper'><div class='card-font'>" . htmlspecialchars($producto['nombre_prod']) . "</div>";
                        echo "<div class='card-font-text'>" . htmlspecialchars($producto['descripcion_prod']) . "</div></div>";
                        echo $isAdmin ? "</div>" : "</a>";

                        echo "<a class='face back' href='#'><div class='img-wrapper'><div class='avatar' style='background-image: url(" . htmlspecialchars($producto['imagen']) . ");'></div></div></a>";
                        echo "</div>";
                        echo "</div>";

                        if ($isAdmin) {
                            echo "<div class='edit-button-container'>";
                            echo "<a href='../pages/editar.php?id=" . htmlspecialchars($producto['id_prod']) . "' class='btn-editar cta-btn common-text'>Editar</a>";
                            echo "<a href='../php/borrarProducto.php?id=" . htmlspecialchars($producto['id_prod']) . "' class='btn-borrar common-text' onclick='return confirmarBorrado();'>Borrar</a>";
                            echo "</div>";
                        }

                        echo "</div>";
                    }
                    echo "</div></div>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }

            $conn->close();
            ?>
        </div>

        <?php echo $Footer ?>
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

        // borrar producto
        function confirmarBorrado() {
            return confirm("¿Estás seguro que quieres borrar este producto?");
        }
    </script>

</body>

</html>