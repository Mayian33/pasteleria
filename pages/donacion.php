<?php include_once('../php/layout.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donaciones Solidarias</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />
    
    <link rel="preload" href="../css/donacion.css" as="style" />
    <link href="../css/donacion.css" rel="stylesheet" />
</head>
<body>
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

                <h2 class="subtitle-text dona-title">¿Cómo funciona?</h2>
                <ul class="common-text list-donacion">
                    <li>Al elegir un producto, puedes marcar la opción para donarlo.</li>
                    <li>Recibirás tu pedido normalmente, pero parte del importe será destinado a una asociación con la que colaboramos.</li>
                    <li>Tu gesto solidario ayudará a apoyar proyectos sociales de forma directa.</li>
                </ul>

                <h2 class="subtitle-text dona-title">Asociación activa</h2>
                <div class="logos-asoc">
                    <div class="text-asoc">
                        <img src="../assets/img/logos/asociaciones/asoc1.png" alt="Logo Asociación Sonrisas Dulces">
                        <p class="common-text"><strong>Asociación Sonrisas Dulces</strong><br> Lleva dulces a niños en hospitales.</p>
                    </div>
                </div>

                <div class="donacion-footer">
                    <a href="../pages/catalogue.php" class="cta-btn common-text btn-dona">
                        Ver productos donables
                    </a>
                    <p class="common-text text-info">
                        Gracias por colaborar. Cada aportación suma.
                    </p>
                    <form action="procesar_donacion.php" method="POST"></form>
                </div>
            </div>
        </div>

        <?php echo $Footer ?>
    </section>
</body>
</html>
