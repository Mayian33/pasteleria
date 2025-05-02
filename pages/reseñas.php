<?php
include_once('../php/conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas - Pastelería Deliciosa</title>
    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />
</head>
<body>

    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <main class="main">
        <h1 class="title">Reseñas de Nuestros Clientes</h1>
        <h2 class="subtitle-text">Lo que dicen sobre nosotros</h2>

        <div class="reviews">
            <div class="review-card">
                <div class="profile-img">
                    <img src="../assets/images/user1.jpg" alt="Usuario 1">
                </div>
                <h3 class="title-text">María López</h3>
                <p class="common-text">"Las mejores tortas que he probado. ¡Siempre frescas y deliciosas!"</p>
            </div>

            <div class="review-card">
                <div class="profile-img">
                    <img src="../assets/images/user2.jpg" alt="Usuario 2">
                </div>
                <h3 class="title-text">Juan Pérez</h3>
                <p class="common-text">"Un lugar encantador con un servicio excepcional. ¡Volveré sin duda!"</p>
            </div>

            <div class="review-card">
                <div class="profile-img">
                    <img src="../assets/images/user3.jpg" alt="Usuario 3">
                </div>
                <h3 class="title-text">Ana García</h3>
                <p class="common-text">"Me encantan sus cupcakes, son una delicia. ¡Recomendados!"</p>
            </div>
        </div>

        <div class="cta-catalogue">
            <a href="#contact" class="cta-btn">¡Déjanos tu reseña!</a>
        </div>
    </main>

    <footer>
        <p class="common-text">© 2023 Pastelería Deliciosa. Todos los derechos reservados.</p>
    </footer>

    <script>
        // Script para el menú hamburguesa
        const menuToggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.nav');

        menuToggle.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    </script>
</body>
</html>