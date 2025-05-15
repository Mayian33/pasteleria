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

// Consultar categorías
$sql_categorias = "SELECT * FROM categorias";
$result_categorias = $conn->query($sql_categorias);
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

    <h1 class="subtitle-text title-info">Editar Producto: <?php echo htmlspecialchars($producto['nombre_prod']); ?></h1>
    <form action="../php/editarInsert.php?id=<?php echo $producto['id_prod']; ?>" method="post" enctype="multipart/form-data">
        <label for="nombre_prod">Nombre:</label>
        <input type="text" id="nombre_prod" name="nombre_prod" value="<?php echo htmlspecialchars($producto['nombre_prod']); ?>" required />

        <label for="descripcion_prod">Descripción:</label>
        <textarea id="descripcion_prod" name="descripcion_prod" required><?php echo htmlspecialchars($producto['descripcion_prod']); ?></textarea>

        <label for="descripcion_detallada_prod">Descripción detallada:</label>
        <textarea id="descripcion_detallada_prod" name="descripcion_detallada_prod" required><?php echo htmlspecialchars($producto['descripcion_detallada_prod']); ?></textarea>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <?php
            if ($result_categorias->num_rows > 0) {
                while ($row = $result_categorias->fetch_assoc()) {  
                    $selected = ($producto['categoria'] == $row['id_categ']) ? 'selected' : '';
                    echo "<option value='" . $row['id_categ'] . "' $selected>" . $row['nombre_categ'] . "</option>";
                }
            } else {
                echo "<option value='0'>Sin categorías disponibles</option>";
            }
            ?>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" min="0" step="0.01" required />

        <!-- Campo para subir imagen nueva o mantener la actual -->
        <label for="imagen">Nueva imagen (si desea cambiarla):</label>
        <input type="file" name="imagen" id="imagen" />

        <p>Imagen actual: <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen actual" width="100" /></p>

        <button type="submit" class="cta-btn">Guardar Cambios</button>
    </form>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
