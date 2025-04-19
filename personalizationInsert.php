<?php
include_once('conexion.php');
session_start();

// Verificar que el formulario haya sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $sabor = $_POST['sabor'];
    $masa = $_POST['masa'];
    $tamano = $_POST['tamano'];
    $decoracion = $_POST['decoracion'];

    // Verificar que no haya campos vacíos
    if (empty($sabor) || empty($masa) || empty($tamano) || empty($decoracion)) {
        $_SESSION['error'] = "Por favor, selecciona todas las opciones.";
        header("Location: personalization.php"); // Redirigir de nuevo al formulario
        exit();
    }

    // Preparar la consulta para insertar los datos en la base de datos
    $sql = "INSERT INTO personalizacion (sabor_personalizacion, masa_personalizacion, tamano_personalizacion, decoracion_personalizacion) 
            VALUES ('$sabor', '$masa', '$tamano', '$decoracion')";

    if ($conn->query($sql) === TRUE) {
        // Si la inserción es exitosa, redirigir a otra página
        header("Location: carrito.php"); // Cambiar a la página de confirmación
        exit();
    } else {
        // En caso de error, mostrar mensaje
        $_SESSION['error'] = "Hubo un problema al insertar los datos: " . $conn->error;
        header("Location: personalization.php"); // Redirigir de nuevo al formulario
        exit();
    }
}

$conn->close();
?>
