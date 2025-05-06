<?php
include_once('../php/conexion.php');

// Verificar si se recibió el id por GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id_prod = intval($_GET['id']); // Sanitizar id

// Consultar datos del producto
$sql = "SELECT id_prod, nombre_prod, descripcion_prod, categoria, precio, imagen FROM productos WHERE id_prod = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_prod);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();

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
    <form action="editar_producto.php?id=<?php echo $producto['id_prod']; ?>" method="post">
        <label for="nombre_prod">Nombre:</label>
        <input type="text" id="nombre_prod" name="nombre_prod" value="<?php echo htmlspecialchars($producto['nombre_prod']); ?>" required />

        <label for="descripcion_prod">Descripción:</label>
        <textarea id="descripcion_prod" name="descripcion_prod" required><?php echo htmlspecialchars($producto['descripcion_prod']); ?></textarea>

        <label for="categoria">Categoría:</label>
        <select id="categoria" name="categoria" required>
            <option value="1" <?php if ($producto['categoria'] == 1) echo 'selected'; ?>>Tartas</option>
            echo 'selected'; ?>>Bizcochos</option>
            <option value="3" <?php if ($producto['categoria'] == 3) echo 'selected'; ?>>Ponches</option>
            <option value="4" <?php if ($producto['categoria'] != 1 && $producto['categoria'] != 2 && $producto['categoria'] != 3) echo 'selected'; ?>>Otra</option>
        </select>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" min="0" step="0.01" required />

        <label for="imagen">URL de imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?php echo htmlspecialchars($producto['imagen']); ?>" />

        <a type="submit" class="cta-btn">Guardar Cambios</a>
    </form>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>