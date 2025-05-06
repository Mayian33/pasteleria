<?php
include_once('../php/conexion.php');

// Verificar si se recibió el id por GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id_prod = intval($_GET['id']); // Sanitizar id

// Obtener imagen actual desde la base de datos
$sql_img = "SELECT imagen FROM productos WHERE id_prod = ?";
$stmt_img = $conn->prepare($sql_img);
$stmt_img->bind_param("i", $id_prod);
$stmt_img->execute();
$result_img = $stmt_img->get_result();
$row_img = $result_img->fetch_assoc();
$imagen_actual = $row_img['imagen'];
$stmt_img->close();

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $nombre_prod = $_POST['nombre_prod'];
    $descripcion_prod = $_POST['descripcion_prod'];
    $descripcion_detallada_prod = $_POST['descripcion_detallada_prod'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];

    $imagen_nueva = null;

    // Si se sube una nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_tamano = $_FILES['imagen']['size'];

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2 MB

        if (in_array($imagen_tipo, $allowed_types) && $imagen_tamano <= $max_size) {
            // Crear ruta única para la nueva imagen
            $imagen_destino = '../assets/img/catalogue/tartas/' . uniqid('producto_', true) . '.' . pathinfo($imagen_nombre, PATHINFO_EXTENSION);

            if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
                $imagen_nueva = $imagen_destino;
            } else {
                echo "Error al subir la imagen.";
                exit;
            }
        } else {
            echo "Tipo de archivo no permitido o tamaño demasiado grande.";
            exit;
        }
    }

    // Construir la consulta SQL según si hay imagen nueva o no
    if ($imagen_nueva) {
        $sql = "UPDATE productos SET nombre_prod=?, descripcion_prod=?, descripcion_detallada_prod=?, categoria=?, precio=?, imagen=? WHERE id_prod=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssidsi", $nombre_prod, $descripcion_prod, $descripcion_detallada_prod, $categoria, $precio, $imagen_nueva, $id_prod);
    } else {
        $sql = "UPDATE productos SET nombre_prod=?, descripcion_prod=?, descripcion_detallada_prod=?, categoria=?, precio=? WHERE id_prod=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssidi", $nombre_prod, $descripcion_prod, $descripcion_detallada_prod, $categoria, $precio, $id_prod);
    }

    if ($stmt->execute()) {
        header("Location: ../pages/catalogue.php?mensaje=Producto actualizado con éxito");
        exit;
    } else {
        echo "Error al actualizar producto: " . $conn->error;
    }
}
?>
