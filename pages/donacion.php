<?php
include_once('../php/layout.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donaciones Solidarias</title>

        <link rel="preload" href="../css/donacion.css" as="style" />
    <link href="../css/donacion.css" rel="stylesheet" />

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />
</head>

<body>
    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <section class="main">
        <div class="container">
            <div class="content-card">
                <h1 class="title">Donaciones <span>Solidarias</span></h1>
                <p class="common-text text-info">
                    En Brollin creemos en el poder de los pequeños gestos. Por eso, ahora puedes <strong>donar tus productos</strong> a causas solidarias con un solo clic. Cada dulce que compartes puede alegrar la vida de alguien más.
                </p>

                <h2 class="subtitle-text" style="margin-top: 3rem;">¿Cómo funciona?</h2>
                <ul class="common-text" style="margin-top: 1rem; list-style: disc; padding-left: 2rem;">
                    <li>Cuando elijas un producto, podrás marcar la opción para donarlo.</li>
                    <li>Ese producto no será entregado a ti, sino a la asociación elegida.</li>
                    <li>Nos encargamos de llevarlo personalmente a la organización correspondiente.</li>
                </ul>

                <h2 class="subtitle-text">Asociaciones activas</h2>
                <div class="logos-asoc">
                    <div class="text-asco">
                        <img src="../assets/img/logos/asociaciones/asoc1.png" alt="Logo Asociación Sonrisas Dulces" style="width: 150px;">
                        <p class="common-text"><strong>Asociación Sonrisas Dulces</strong><br> Lleva dulces a niños en hospitales.</p>
                    </div>
                    <div style="text-align: center;">
                        <img src="../assets/img/logos/asociaciones/asoc2.png" alt="Logo Comida Solidaria" style="width: 150px;">
                        <p class="common-text"><strong>Comida Solidaria</strong><br> Reparte postres a personas sin hogar.</p>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 3rem;">
                    <a href="../pages/catalogue.php" class="cta-btn common-tex">
                        Ver productos donables
                    </a>
                    <p class="common-text text-info">
                        Gracias por colaborar. Cada aportación suma.
                    </p>
                </div>
            </div>
        </div>
        <?php
        echo $Footer
        ?>
    </section>

</body>

</html>