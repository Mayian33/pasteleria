<?php
include_once('conexion.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>

    <link rel="preload" href="css/estilos-comunes.css" as="style" />
    <link href="css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="css/index.css" as="style" />
    <link href="css/index.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <section class="main">
        <!-- CONTAINER PRINCIPAL -->
        <div class="container">
            <div class="content-card">
                <div class="text-content">
                    <h1 class="title">Dulce<br />&amp;<span>Pasión</span></h1>
                    <p>Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia
                        consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
                    <a class="cta-btn" href="#">
                        Compra Online
                    </a>
                </div>

                <div class="image-content">
                    <img alt="image-principal" src="./assets/img/principal/principal-img.jpg" />
                </div>
            </div>
        </div>

        <!-- SECTION INFO -->
        <section id="sobremi">
            <div class="container-info">
                <img class="img-info" src="./assets/img/principal/info-img.jpg">
                <div class="content-info">
                    <h2 class="regular-title subtitle-info">Sobre mi</h2>
                    <h1 class="subtitle-text title-info">El <span>Sabor</span> Que necesitas, para tu placer.</h1>
                    <p>At Bakery Co., we believe that every day deserves a little sweetness. Our artisan bakery is your
                        one-stop destination for baked treats that burst with flavor and melt in your mouth. With a
                        passion
                        for
                        baking that has been passed down through generations, we take pride in creating mouth-watering
                        pastries
                        that delight your taste buds.</p>
                    <br>
                    <a class="cta-btn" href="#">More about us</a>
                </div>
            </div>
        </section>

        <!-- CARDS -->

        <div class="cards-title">
            <h1 class="title-text subtitle-text"> <span>Delicias Caseras:</span> El Sabor de lo Hecho con Amor</h1>
            <p class="text">Un catálogo de productos frescos y auténticos para endulzar tus momentos</p>
        </div>

        <div class="cards-wrapper">
            <div class="card-wrapper">
                <div class="card-1 card-object card-object-hf"><a class="face front" href="#">
                        <div class="title-wrapper">
                            <div class="card-font">Ponche</div>
                            <div class="card-font-text">Sabor casero</div>
                        </div>
                    </a></div>
            </div>
            <div class="card-wrapper">
                <div class="card-2 card-object card-object-hf"><a class="face front" href="#">
                        <div class="title-wrapper">
                            <div class="card-font">Tartas</div>
                            <div class="card-font-text">Pura delicia</div>
                        </div>
                    </a></div>
            </div>
            <div class="card-wrapper">
                <div class="card-3 card-object card-object-hf"><a class="face front" href="#">
                        <div class="title-wrapper">
                            <div class="card-font">Bizcochos</div>
                            <div class="card-font-text">Bocado perfecto</div>
                        </div>
                    </a></div>
            </div>
        </div>
        <div class="cta-catalogue">
            <a class="cta-btn" href="#">
                Ver catálogo completo
            </a>
        </div>

        <!-- SECCION PERSONALIZACION -->
        <section id="personalization" class="personalization-section">
            <div class="personalization-wrapper">
                <img class="img-personalization" src="./assets/img/principal/principal-img.jpg">
                <div class="personalization-content">
                    <h2 class="regular-title subtitle-perso">Personalización</h2>
                    <h1 class="subtitle-text title-perso">Dulces <span>Personalizados</span> para tus momentos especiales</h1>
                    <p>¿Quieres sorprender a alguien con un regalo único y especial? En Bróllin Pastelería, creamos
                        dulces personalizados para que celebres tus momentos más especiales </p>
                    <br>
                    <a class="cta-btn" href="#">Personalizar ahora</a>
                </div>
            </div>
        </section>

        <!-- footer -->
        <footer>
            <div class="footer-card">
                <div class="logo-footer">
                    <img src="./assets//img/logos/logo_menu.png" alt="logo">
                </div>

                <div class="footer-text">
                    <p class="text">Endulzando tus días con cada creación casera.
                    <div class="frase">
                        <b>¡Gracias por confiar en nosotros!</b>
                    </div>
                    </p>
                </div>

                <div class="logos">
                    <img src="./assets/img/logos/instagram.png" alt="logo1">
                    <img src="./assets/img/logos/marker.png" alt="logo2">
                    <img src="./assets/img/logos/whatsapp.png" alt="logo3">
                </div>

                <div class="footer-info">
                    <p>© 2025 - Bróllin | pasteleria</p>
                    <div class="footer-policies">
                        <p>Política de Privacidad</p>
                        <p>Política de Cookies</p>
                    </div>
                </div>
            </div>
        </footer>
    </section>

    <!-- SCRIPTS -->
    <script src="js/index.js"></script>

</body>

</html>