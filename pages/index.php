<?php
include_once('../php/conexion.php');





// Obtener las imágenes de la base de datos
$sql = "SELECT imagen FROM productos";
$result = $conn->query($sql);
$imagenes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imagenes[] = $row['imagen']; // Guardamos las rutas de las imágenes
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/index.css" as="style" />
    <link href="../css/index.css" rel="stylesheet" />

</head>

<body>
    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>


    <section class="main">
        <!-- CONTAINER PRINCIPAL -->
        <div class="container container-principal">
            <div class="content-card">
                <div class="text-content">
                    <h1 class="title">Dulce<br />&amp;<span>Pasión</span></h1>
                    <p class="common-text">Pastelería artesanal y casera, hecha con amor y dedicación. Tartas, bizcochos y ponches únicos para endulzar tus momentos más especiales. ¡Sabor auténtico, como en casa!</p>
                    <a class="cta-btn" href="../pages/catalogue.php">
                        Compra Online
                    </a>
                </div>

                <!-- CAROUSEL -->
                <div class="carrusel-body">
                    <?php foreach ($imagenes as $index => $imagen): ?>
                        <input type="radio" name="slider" id="item-<?= $index + 1 ?>" <?= $index == 0 ? 'checked' : '' ?>>
                    <?php endforeach; ?>

                    <div class="carrusel-container">
                        <div class="carrusel-cards">
                            <?php foreach ($imagenes as $index => $imagen): ?>
                                <label class="carrusel-card" for="item-<?= $index + 1 ?>" id="song-<?= $index + 1 ?>">
                                    <img src="<?= $imagen ?>" alt="Imagen <?= $index + 1 ?>" class="carrusel-img">
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const slides = document.querySelectorAll('input[name="slider"]');
                        let currentSlide = 0;
                        const totalSlides = slides.length;

                        function updateSlides() {
                            // Oculta todas las imágenes primero
                            document.querySelectorAll('.carrusel-card').forEach(card => {
                                card.style.transform = 'translateX(40%) scale(0.8)';
                                card.style.opacity = '0.4';
                                card.style.zIndex = '0';
                            });

                            // Muestra la imagen actual
                            const currentCard = document.querySelector(`#song-${currentSlide + 1}`);
                            if (currentCard) {
                                currentCard.style.transform = 'translateX(0) scale(1)';
                                currentCard.style.opacity = '1';
                                currentCard.style.zIndex = '1';
                            }

                            // Muestra la imagen anterior (izquierda)
                            const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
                            const prevCard = document.querySelector(`#song-${prevIndex + 1}`);
                            if (prevCard) {
                                prevCard.style.transform = 'translateX(-40%) scale(0.8)';
                                prevCard.style.opacity = '0.4';
                                prevCard.style.zIndex = '0';
                            }

                            // Muestra la siguiente imagen (derecha)
                            const nextIndex = (currentSlide + 1) % totalSlides;
                            const nextCard = document.querySelector(`#song-${nextIndex + 1}`);
                            if (nextCard) {
                                nextCard.style.transform = 'translateX(40%) scale(0.8)';
                                nextCard.style.opacity = '0.4';
                                nextCard.style.zIndex = '0';
                            }
                        }

                        function nextSlide() {
                            currentSlide = (currentSlide + 1) % totalSlides;
                            slides[currentSlide].checked = true;
                            updateSlides();
                        }

                        // Inicializar
                        updateSlides();

                        // Configurar intervalo
                        let interval = setInterval(nextSlide, 3000);

                        // Pausar al hacer hover
                        const carrusel = document.querySelector('.carrusel-container');
                        carrusel.addEventListener('mouseenter', () => clearInterval(interval));
                        carrusel.addEventListener('mouseleave', () => interval = setInterval(nextSlide, 3000));
                    });
                </script>

                <!-- FIN CAROUSEL -->


            </div>
        </div>

        <!-- SECTION INFO -->
        <section id="sobremi">
            <div class="container-info">
                <img class="img-info" src="../assets/img/principal/info-img.jpg">
                <div class="content-info">
                    <h2 class="regular-title subtitle-info">Sobre mi</h2>
                    <h1 class="subtitle-text title-info">El <span>Sabor</span> Que necesitas, para tu placer.</h1>
                    <p class="common-text">At Bakery Co., we believe that every day deserves a little sweetness. Our artisan bakery is your
                        one-stop destination for baked treats that burst with flavor and melt in your mouth. With a
                        passion
                        for
                        baking that has been passed down through generations, we take pride in creating mouth-watering
                        pastries
                        that delight your taste buds.</p>
                    <br>
                    <a class="cta-btn" href="../pages/sobreMi.php">More about us</a>
                </div>
            </div>
        </section>

        <!-- CARDS -->
        <?php
        $sql = "SELECT id_categ, nombre_categ, descripcion_categ FROM categorias";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="cards-title">
    <h1 class="title-text subtitle-text"> <span>Delicias Caseras:</span> El Sabor de lo Hecho con Amor</h1>
    <p class="common-text">Un catálogo de productos frescos y auténticos para endulzar tus momentos</p>
  </div>';
            echo '<div class="cards-wrapper">';

            while ($row = $result->fetch_assoc()) {
                $nombre_categ = $row['nombre_categ'];
                $descripcion_categ = $row['descripcion_categ'];
                // Generar id_categ consistentemente con nombre en minúsculas sin espacios
                $id_categ = strtolower(trim($nombre_categ));
                echo '<div class="card-wrapper">
        <div class="card-' . htmlspecialchars($row['id_categ']) . ' card-object card-object-hf">
            <a class="face front" href="catalogue.php#' . $id_categ . '">
                <div class="title-wrapper">
                    <div class="card-font">' . htmlspecialchars($nombre_categ) . '</div>
                    <div class="card-font-text common-text">' . htmlspecialchars($descripcion_categ) . '</div>
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
  </div>';
        } else {
            echo "No hay productos disponibles.";
        }
        ?>

        <!-- SECCION PERSONALIZACION -->
        <section id="personalization" class="personalization-section">
            <div class="personalization-wrapper">
                <img class="img-personalization" src="../assets/img/principal/principal-img.jpg">
                <div class="personalization-content">
                    <h2 class="regular-title subtitle-info">Personalización</h2>
                    <h1 class="subtitle-text title-info">Dulces <span>Personalizados</span> para tus momentos especiales</h1>
                    <p class="common-text">¿Quieres sorprender a alguien con un regalo único y especial? En Bróllin Pastelería, creamos
                        dulces personalizados para que celebres tus momentos más especiales </p>
                    <br>
                    <a class="cta-btn" href="personalization.php">Personalizar ahora</a>
                </div>
            </div>
        </section>

        <?php
        echo $Footer
        ?>
    </section>

    <!-- SCRIPTS -->
    <script src="../js/index.js"></script>

</body>

</html>