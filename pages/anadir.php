<?php
include_once('../php/conexion.php');

$sql_categorias = "SELECT * FROM categorias";
$result = $conn->query($sql_categorias);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agregar Producto</title>
    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/editarAnadir.css" as="style" />
    <link href="../css/editarAnadir.css" rel="stylesheet" />
</head>

<body>
    <h1>Agregar Nuevo Producto</h1>
    <form action="../php/anadirInsert.php" method="post" enctype="multipart/form-data">
        <label for="nombre_prod">Nombre:</label>
        <input type="text" id="nombre_prod" name="nombre_prod" required />

        <label for="descripcion_prod">Descripción:</label>
        <textarea id="descripcion_prod" name="descripcion_prod" required></textarea>

        <label for="descripcion_prod">Descripción detallada:</label>
        <textarea id="descripcion_detallada_prod" name="descripcion_detallada_prod" required></textarea>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id_categ'] . "'>" . $row['nombre_categ'] . "</option>";
                }
            } else {
                echo "<option value='0'>Sin categorías disponibles</option>";
            }
            ?>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" min="0" step="0.01" required />

        <!--Imagen -->
        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" required />

        <button type="submit" class="cta-btn">Agregar Producto</button>
    </form>
</body>

</html>
