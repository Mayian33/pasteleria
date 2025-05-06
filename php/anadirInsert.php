<?php
include_once('../php/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos del formulario
    $nombre_prod = $_POST['nombre_prod'];
    $descripcion_prod = $_POST['descripcion_prod'];
    $descripcion_detallada_prod = $_POST['descripcion_detallada_prod'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];

    // Inicializamos la ruta de la imagen por defecto
    $imagen = 'assets/img/catalogue/tartas/default.jpg'; // Imagen predeterminada en caso de no subir ninguna

    // Comprobamos si se ha subido una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $imagen_tipo = $_FILES['imagen']['type'];
        $imagen_tamano = $_FILES['imagen']['size'];

        // Validamos el tipo y tamaño de la imagen
        $allowed_types = ['image/jpeg', 'image/png']; 
        $max_size = 2 * 1024 * 1024; // 2 MB en bytes

        if (in_array($imagen_tipo, $allowed_types) && $imagen_tamano <= $max_size) {
            // Validar extensión
            $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($imagen_nombre, PATHINFO_EXTENSION));

            if (!in_array($ext, $extensiones_permitidas)) {
                echo "La extensión del archivo no es válida.";
                exit;
            }

            // Creamos una ruta única para la imagen (para evitar colisiones de nombres)
            $imagen_destino = '../assets/img/catalogue/tartas/' . uniqid('producto_', true) . '.' . $ext;

            // Movemos el archivo a la carpeta 'assets/img/catalogue/tartas/'
            if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
                // Si la imagen se subió correctamente, actualizamos la variable $imagen
                $imagen = $imagen_destino;
            } else {
                echo "Error al subir la imagen.";
                exit;
            }
        } else {
            echo "Tipo de archivo no permitido o tamaño demasiado grande.";
            exit;
        }
    }

    // Insertamos el producto en la base de datos
    $sql = "INSERT INTO productos (nombre_prod, descripcion_prod, descripcion_detallada_prod, categoria, precio, imagen) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssids", $nombre_prod, $descripcion_prod, $descripcion_detallada_prod, $categoria, $precio, $imagen);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: ../pages/catalogue.php?mensaje=Producto agregado con éxito");
        exit;
    } else {
        echo "Error al agregar producto: " . $conn->error;
        exit;
    }
} else {
    echo "Error: No se recibió el formulario correctamente.";
}
