<?php
include_once('../php/layout.php');

// Verificar si se recibió el id por GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id_prod = intval($_GET['id']); // Sanitizar id

// Consultar datos del producto
$sql = "SELECT id_prod, nombre_prod, descripcion_prod, descripcion_detallada_prod, categoria, precio, imagen FROM productos WHERE id_prod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_prod);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();

// Guardar categorías en array
$categorias = [];
$sql_categorias = "SELECT * FROM categorias";
$result_categorias = $conn->query($sql_categorias);

while ($row = $result_categorias->fetch_assoc()) {
    $categorias[] = $row;
    if ($row['id_categ'] == $producto['categoria']) {
        $categoria_actual = $row['nombre_categ'];
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Producto - <?php echo htmlspecialchars($producto['nombre_prod']); ?></title>

    <link rel="preload" href="../css/estilos-comunes.css" as="style" />
    <link href="../css/estilos-comunes.css" rel="stylesheet" />

    <link rel="preload" href="../css/editarAnadir.css" as="style" />
    <link href="../css/editarAnadir.css" rel="stylesheet" />
</head>

<body>

    <!-- MENU NAVBAR -->
    <header>
        <?php echo $Menu ?>
    </header>

    <h1 class="subtitle-text title-info title-edit"> Editar Producto: <?php echo ucwords(htmlspecialchars($categoria_actual)); ?> - <?php echo ucwords(htmlspecialchars($producto['nombre_prod'])); ?></h1>
    <form action="../php/editarInsert.php?id=<?php echo $producto['id_prod']; ?>" method="post" enctype="multipart/form-data">
        <label class="common-text" for="nombre_prod">Nombre:</label>
        <input type="text" id="nombre_prod" name="nombre_prod" value="<?php echo htmlspecialchars($producto['nombre_prod']); ?>" required />

        <label class="common-text" for="descripcion_prod">Palabra descriptiva:</label>
        <textarea id="descripcion_prod" name="descripcion_prod" required><?php echo htmlspecialchars($producto['descripcion_prod']); ?></textarea>

        <label class="common-text" for="descripcion_detallada_prod">Descripción detallada:</label>
        <textarea id="descripcion_detallada_prod" name="descripcion_detallada_prod" required><?php echo htmlspecialchars($producto['descripcion_detallada_prod']); ?></textarea>

        <label class="common-text" for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php
            if ($result_categorias->num_rows > 0) {
                foreach ($categorias as $row) {
                    $selected = ($producto['categoria'] == $row['id_categ']) ? 'selected' : '';
                    echo "<option value='" . $row['id_categ'] . "' $selected>" . htmlspecialchars($row['nombre_categ']) . "</option>";
                }
            } else {
                echo "<option value='0'>Sin categorías disponibles</option>";
            }
            ?>
        </select>

        <label class="common-text" for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" min="0" step="0.01" required />

        <!-- Campo para subir imagen nueva o mantener la actual -->
        <div class="imagen-wrapper">
            <label class="common-text" for="imagen">Nueva imagen:</label>
            <input class="common-text" type="file" name="imagen" id="imagen" accept="image/*" />

            <p>Imagen actual:</p>
            <img id="preview" src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen actual" width="100" />
        </div>


        <div class="btn-submit">
            <button type="submit" class="cta-btn common-text ">Guardar Cambios</button>
        </div>

    </form>

    <script>
        const input = document.getElementById('imagen');
        const preview = document.getElementById('preview');

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>


</body>

</html>

<?php
$stmt->close();
$conn->close();
?>