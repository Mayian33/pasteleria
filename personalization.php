<?php
include_once('conexion.php');

$sql1 = "SELECT * FROM sabor";
$result1 = $conn->query($sql1);

$sql2 = "SELECT * FROM masa";
$result2 = $conn->query($sql2);

$sql3 = "SELECT * FROM tamano";
$result3 = $conn->query($sql3);

$sql4 = "SELECT * FROM decoracion";
$result4 = $conn->query($sql4);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalización</title>

    <link rel="preload" href="css/estilos-comunes.css" as="style" />
    <link href="css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="css/personalizacion.css" as="style" />
    <link href="css/personalizacion.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- NAV -->
    <header>
        <?php echo $Menu ?>
    </header>

    <!-- CONTENIDO PERSONALIZACIÓN -->
    <section class="personalization-wrapper">
        <div class="personalization-content">
            <h1 class="subtitle-text title-info">Personalización</h1>
            <p class="common-text">¿Qué te apetece hoy?</p>

            <?php if ($result2->num_rows > 0): ?>
                <form id="mainForm" class="formulario-personalizacion">
                    <p class="common-text">Elige entre las siguientes opciones:</p>

                    <!-- Sabor -->
                    <div class="form-group">
                        <label class="common-text" for="saborSelect">Sabor:</label>
                        <select id="saborSelect">
                            <option value="">Elige un sabor</option>
                            <?php while ($row1 = $result1->fetch_assoc()): ?>
                                <option value="<?= $row1['id_sabor'] ?>"><?= $row1['nombre_sabor'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Masa -->
                    <div class="form-group">
                        <label class="common-text" for="masaSelect">Masa:</label>
                        <select id="masaSelect">
                            <option value="">Elige una masa</option>
                            <?php while ($row2 = $result2->fetch_assoc()): ?>
                                <option value="<?= $row2['id_masa'] ?>"><?= $row2['nombre_masa'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Tamaño -->
                    <div class="form-group">
                        <label class="common-text" for="tamanoSelect">Tamaño:</label>
                        <select id="tamanoSelect">
                            <option value="">Elige un tamaño</option>
                            <?php while ($row3 = $result3->fetch_assoc()): ?>
                                <option value="<?= $row3['id_tamano'] ?>"><?= $row3['nombre_tamano'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Decoración -->
                    <div class="form-group">
                        <label class="common-text" for="decoracionSelect">Decoración:</label>
                        <select id="decoracionSelect">
                            <option value="">Elige una decoración</option>
                            <?php while ($row4 = $result4->fetch_assoc()): ?>
                                <option value="<?= $row4['id_decoracion'] ?>"><?= $row4['nombre_decoracion'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>


                    <div class="form-buttons">
                        <a class="cta-btn" onclick="redirigirComprar()">Comprar</a>
                        <a class="cta-btn" onclick="redirigirAnadir()">Añadir</a>
                    </div>

                </form>
            <?php else: ?>
                <p class="common-text">No hay tipos de productos disponibles.</p>
            <?php endif; ?>
        </div>
    </section>

        <!-- SCRIPTS -->
        <script src="js/catalogue.js"></script>
</body>

</html>