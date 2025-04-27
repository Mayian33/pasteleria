<?php
include_once('conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sabor = $_POST['sabor'];
    $masa = $_POST['masa'];
    $tamano = $_POST['tamano'];
    $decoracion = $_POST['decoracion'];

    if (empty($sabor) || empty($masa) || empty($tamano) || empty($decoracion)) {
        $_SESSION['error'] = "Por favor, selecciona todas las opciones.";
        header("Location: personalization.php");
        exit();
    }

    // Preparar la consulta para insertar los datos en la base de datos
    $sql = "INSERT INTO personalizacion (sabor_personalizacion, masa_personalizacion, tamano_personalizacion, decoracion_personalizacion) 
            VALUES ('$sabor', '$masa', '$tamano', '$decoracion')";

    if ($conn->query($sql) === TRUE) {
        header("Location: carrito.php");
        exit();
    } else {
        $_SESSION['error'] = "Hubo un problema al insertar los datos: " . $conn->error;
        header("Location: personalization.php"); 
        exit();
    }
}

$conn->close();
?>
