<?php
include_once('../php/layout.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre mí - Pastelería</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <style>
        .about-container {
            background-color: var(--white);
            border-radius: 2rem;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .about-title {
            text-align: center;
            font-family: title;
            font-size: 50px;
            color: var(--details);
            margin-bottom: 1.5rem;
        }

        .about-text {
            font-family: text;

            color: var(--details);
            line-height: 1.8;
            text-align: justify;
        }

        .bible-verse {
            font-style: italic;
            margin-top: 2rem;
            text-align: center;
            font-size: 16px;
            color: var(--secondary);
        }


        .gallery {
            margin-top: 3rem;
            text-align: center;
        }

        .gallery-title {
            font-family: subtitle;
            font-size: 30px;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .gallery-photos {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .gallery-photos img {
            width: 300px;
            height: auto;
            border-radius: 1rem;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-photos img:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <header>
        <?php echo $Menu ?>
    </header>

    <main class="main">
        <section class="about-container">
            <h1 class="about-title">Sobre mí</h1>
            <p class="about-text">
                Hola, soy Yokaterine, la persona detrás de esta pastelería. Desde pequeña he sentido pasión por la repostería y, con la ayuda de Dios, decidí convertir ese sueño en realidad. Cada producto está hecho a mano, con ingredientes frescos y mucho cariño.
            </p>
            <p class="about-text common-text">
                Para mí, este negocio no es solo una forma de ganarme la vida, sino también una manera de servir a los demás. Creo que a través de cosas sencillas, como un dulce, se puede compartir alegría y amor, valores en los que creo profundamente como parte de mi fe cristiana.
            </p>
            <p class="about-text common-text">
                Mi objetivo es que cada bocado no solo endulce tu día, sino que también refleje un poquito del amor de Dios. Gracias por apoyar este proyecto, que es un regalo y una misión para mí.
            </p>
            <p class="bible-verse">
                "Y todo lo que hagáis, hacedlo de corazón, como para el Señor y no para los hombres."<br>
                — Colosenses 3:23
            </p>
        </section>

        <div class="gallery">
            <h2 class="subtitle-text">Un vistazo a mi trabajo</h2>
            <div class="gallery-photos">
                <img src="../assets/img/sobreMi/foto1.jpg" alt="Foto cocinando 1">
                <img src="../assets/img/sobreMi/foto2.jpg" alt="Foto cocinando 2">
                <img src="../assets/img/sobreMi/foto3.jpg" alt="Foto cocinando 3">
            </div>
        </div>
    </main>
</body>

</html>