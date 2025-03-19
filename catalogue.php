<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="preload" href="css/catalogue.css" as="style" />
    <link href="css/catalogue.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- MENU NAVBAR -->
    <header>
        <div class="navbar" id="home">
            <nav>
                <div class="logo">
                    <img alt="logo" src="/assets/img/logos/logo_menu.png" />
                </div>
                <div class="menu-toggle" onclick="toggleMenu()">☰</div>
                <nav class="nav">
                    <a href="#home">Home</a>
                    <a href="#sobremi">Sobre mí</a>
                    <a href="#">Menú</a>
                    <a href="#">Reseñas</a>
                    <a href="#personalizacion">Personalización</a>
                    <a href="#">Contacto</a>
                </nav>
                <a class="cta-btn btn-menu" href="#">
                    Hacer una Reserva
                </a>
            </nav>
        </div>
    </header>

    <!-- Sección de catálogo de productos -->
    <section id="catalogo">
        <div class="container-catalogue">
            <h1 class="title title-catalogue">Catálogo de productos</h1>
        </div>

        <div class="cards-wrapper">
            <?php
            $servername = "localhost"; // Cambia esto si tu servidor es diferente
            $username = "root"; // Cambia esto por tu usuario de MySQL
            $password = ""; // Cambia esto por tu contraseña de MySQL
            $dbname = "brollin"; // Cambia esto por el nombre de tu base de datos

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener los productos de la base de datos
            $sql = "SELECT id_prod, nombre_prod, descripcion_prod, categoria, precio, imagen FROM productos";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Recorrer los resultados y mostrarlos
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card-wrapper'>";
                    echo "<div class='card-1 card-object card-object-hf'>";
                    echo "<a class='face front' href='#' style='background-image: url(" . htmlspecialchars($row['imagen']) . ");'>";
                    echo "<div class='title-wrapper'>";
                    echo "<div class='card-font'>" . htmlspecialchars($row['nombre_prod']) . "</div>";
                    echo "<div class='card-font-text'>" . htmlspecialchars($row['descripcion_prod']) . "</div>";
                    echo "</div></a>";
                    echo "<a class='face back' href='#'>";
                    echo "<div class='img-wrapper'>";
                    echo "<div class='avatar' style='background-image: url(" . htmlspecialchars($row['imagen']) . ");'></div>";
                    echo "</div></a>";
                    echo "</div>"; // Cierra card-1
                    echo "</div>"; // Cierra card-wrapper
                    }
                } else {
                    echo "<p>No hay productos disponibles.</p>";
                }
    
                $conn->close();
                ?>
            </div>
        </section>
    
    </body>
    
    </html>