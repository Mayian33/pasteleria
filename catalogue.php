<?php
include_once('conexion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="preload" href="css/estilos-comunes.css" as="style" />
    <link href="css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="css/catalogue.css" as="style" />
    <link href="css/catalogue.css" rel="stylesheet" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <!-- Sección de catálogo de productos -->
    <section id="catalogo">
        <div class="container-catalogue">
            <h1 class="subtitle-text title-info">Catálogo de Productos <span>Caseros</span></h1>
        </div>

        <div class="cards-wrapper">
            <?php
 

            // Obtener los productos de la base de datos
            $sql = "SELECT id_prod, nombre_prod, descripcion_prod, categoria, precio, imagen FROM productos";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Inicializar un array para almacenar productos por categoría
                $productosPorCategoria = [];

                // Mapeo de categorías
                $categorias = [
                    '1' => 'Tarta',
                    '2' => 'Bizcocho',
                    '3' => 'Ponche'
                ];

                // Recorrer los resultados y agruparlos por categoría
                while ($row = $result->fetch_assoc()) {
                    $categoria = $row['categoria'];
                    // Convertir el número de categoría a texto
                    if (isset($categorias[$categoria])) {
                        $categoriaTexto = $categorias[$categoria];
                    } else {
                        $categoriaTexto = 'Otra'; // Para categorías no mapeadas
                    }

                    if (!isset($productosPorCategoria[$categoriaTexto])) {
                        $productosPorCategoria[$categoriaTexto] = [];
                    }
                    $productosPorCategoria[$categoriaTexto][] = $row;
                }

                // Mostrar productos organizados por categoría
                foreach ($productosPorCategoria as $categoria => $productos) {
                    echo "<div class='cards-title'>"; // Contenedor para el título de la categoría
                    echo "<h2 class='subtitle-text title-info categoria-titulo'>" . htmlspecialchars(ucfirst($categoria)) . "</h2>"; // Muestra el nombre de la categoría
                    echo " </div>";
                    echo "<div class='productos'>"; // Contenedor para los productos
                    foreach ($productos as $producto) {
                        echo "<div class='card-wrapper'>";
                        echo "<div class='card-1 card-object card-object-hf'>";
                        echo "<a class='face front' href='#' style='background-image: url(" . htmlspecialchars($producto['imagen']) . ");'>";
                        echo "<div class='title-wrapper'>";
                        echo "<div class='card-font'>" . htmlspecialchars($producto['nombre_prod']) . "</div>";
                        echo "<div class='card-font-text'>" . htmlspecialchars($producto['descripcion_prod']) . "</div>";
                        echo "</div></a>";
                        echo "<a class='face back' href='#'>";
                        echo "<div class='img-wrapper'>";
                        echo "<div class='avatar' style='background-image: url(" . htmlspecialchars($producto['imagen']) . ");'></div>";
                        echo "</div></a>";
                        echo "</div>"; // Cierra card-1
                        echo "</div>"; // Cierra card-wrapper
                    }
                    echo "</div>"; // Cierra el contenedor de productos
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }

            $conn->close();