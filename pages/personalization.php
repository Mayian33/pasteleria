<?php
include_once('../php/layout.php');

// Consultas
$sql1 = "SELECT * FROM sabor";
$sql2 = "SELECT * FROM masa";
$sql3 = "SELECT * FROM tamano";
$sql4 = "SELECT * FROM decoracion";

$result1 = $conn->query($sql1);
$sabores = $result1->fetch_all(MYSQLI_ASSOC);

$result2 = $conn->query($sql2);
$masas = $result2->fetch_all(MYSQLI_ASSOC);

$result3 = $conn->query($sql3);
$tamanos = $result3->fetch_all(MYSQLI_ASSOC);

$result4 = $conn->query($sql4);
$decoraciones = $result4->fetch_all(MYSQLI_ASSOC);

$sql5 = "SELECT * FROM opciones";
$result5 = $conn->query($sql5);
$opciones = $result5->fetch_all(MYSQLI_ASSOC);


$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalización</title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/personalizacion.css" as="style" />
    <link href="../css/personalizacion.css" rel="stylesheet" />

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
</head>

<body>

    <header>
        <?php echo $Menu ?>
    </header>

    <section class="personalization-wrapper main">
        <div class="personalization-content">
            <h1 class="subtitle-text title-info">Personaliza Tu Tarta</h1>
            <p class="common-text">¿Qué te apetece hoy?</p>

            <!-- Mostrar errores si existen -->
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-msg"><?= $_SESSION['error'] ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (count($masas) > 0): ?>
                <form id="mainForm" class="formulario-personalizacion" action="../php/personalizationInsert.php" method="POST">
                    <p class="common-text info-text"><b> Elige entre las siguientes opciones:</b></p>

                    <!-- Sabor -->
                    <div class="form-group">
                        <label class="common-text" for="saborSelect">Sabor:</label>
                        <select name="sabor" id="saborSelect">
                            <option value="">Elige un sabor</option>
                            <?php foreach ($sabores as $sabor): ?>
                                <option value="<?= $sabor['id_sabor'] ?>"><?= $sabor['nombre_sabor'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Masa -->
                    <div class="form-group">
                        <label class="common-text" for="masaSelect">Masa:</label>
                        <select name="masa" id="masaSelect">
                            <option value="">Elige una masa</option>
                            <?php foreach ($masas as $masa): ?>
                                <option value="<?= $masa['id_masa'] ?>"><?= $masa['nombre_masa'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tamaño -->
                    <div class="form-group">
                        <label class="common-text" for="tamanoSelect">Tamaño:</label>
                        <select name="tamano" id="tamanoSelect">
                            <option value="">Elige un tamaño</option>
                            <?php foreach ($tamanos as $tamano): ?>
                                <option value="<?= $tamano['id_tamano'] ?>"><?= $tamano['nombre_tamano'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Decoración -->
                    <div class="form-group">
                        <label class="common-text" for="decoracionSelect">Decoración:</label>
                        <select name="decoracion" id="decoracionSelect">
                            <option value="">Elige una decoración</option>
                            <?php foreach ($decoraciones as $deco): ?>
                                <option value="<?= $deco['id_decoracion'] ?>"><?= $deco['nombre_decoracion'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Opciones de personalización alimentaria -->
                    <p class="common-text info-text"><b> Opciones adicionales:</b></p>


                    <?php foreach ($opciones as $opcion): ?>
                        <div class="form-group-option">
                            <label class="common-text" for="opcion-<?= $opcion['nombre_opcion'] ?>">
                                <input type="checkbox" id="opcion-<?= $opcion['nombre_opcion'] ?>" name="opciones[]" value="<?= $opcion['nombre_opcion'] ?>">
                                <?= $opcion['nombre_opcion'] ?>
                            </label>
                        </div>
                    <?php endforeach; ?>


                    <div class="form-buttons">
                        <button type="submit" class="cta-btn common-text">Añadir</button>
                    </div>

                </form>
            <?php else: ?>
                <p class="common-text">No hay tipos de productos disponibles.</p>
            <?php endif; ?>
        </div>

        <?php
        echo $Footer
        ?>
    </section>





    <!-- <script src="js/catalogue.js"></script> -->

</body>

</html>