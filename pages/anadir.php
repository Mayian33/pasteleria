<?php
include_once('../php/layout.php');

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
            <option value="" disabled selected>Seleccionar categoría</option>
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

        <div class="imagen-wrapper">
            <label class="common-text" for="imagen">Nueva imagen:</label>
            <input class="common-text" type="file" name="imagen" id="imagen" accept="image/*" />

            <p id="texto-sin-imagen">Aún no hay imagen seleccionada</p>
            <img id="preview" src="" alt="Vista previa" width="100" style="display: none;" />
        </div>


        <div class="btn-submit">
            <button type="submit" class="cta-btn common-text ">Guardar Cambios</button>
        </div>
    </form>

    <script>
        document.getElementById('imagen').addEventListener('change', function() {
            const file = this.files[0];
            const preview = document.getElementById('preview');
            const texto = document.getElementById('texto-sin-imagen');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    texto.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                texto.style.display = 'block';
            }
        });
    </script>


</body>

</html>