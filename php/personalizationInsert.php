<?php
session_start();
include_once('../php/conexion.php');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sabor = intval($_POST['sabor']);
    $masa = intval($_POST['masa']);
    $tamano = intval($_POST['tamano']);
    $decoracion = intval($_POST['decoracion']);

    if (empty($sabor) || empty($masa) || empty($tamano) || empty($decoracion)) {
        $_SESSION['error'] = "Por favor, selecciona todas las opciones.";
        header("Location: ../pages/personalization.php");
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];
    $fecha = date("Y-m-d H:i:s");

    // Aquí hacemos una sola consulta para traer todos los precios
    $sql = "
        SELECT 
            (SELECT precio_masa FROM masa WHERE id_masa = ?) +
            (SELECT precio_tamano FROM tamano WHERE id_tamano = ?) +
            (SELECT precio_decoracion FROM decoracion WHERE id_decoracion = ?) +
            (SELECT precio_sabor FROM sabor WHERE id_sabor = ?) AS precio_total
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $masa, $tamano, $decoracion, $sabor);
    $stmt->execute();
    $stmt->bind_result($precio_total);
    $stmt->fetch();
    $stmt->close();

    $imagen = 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg';

    // Insertar todo en la tabla personalizacion iiiiisds
    $stmt = $conn->prepare("INSERT INTO personalizacion (usuario_personalizacion, sabor_personalizacion, masa_personalizacion, tamano_personalizacion, decoracion_personalizacion, fecha_personalizacion, precio_personalizacion, imagen_personalizacion) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiisds", $usuario_id, $sabor, $masa, $tamano, $decoracion, $fecha, $precio_total, $imagen);

    if ($stmt->execute()) {
        $personalizacion_id = $conn->insert_id;

        $stmt = $conn->prepare("INSERT INTO carrito (usuario_carrito, personalizacion_id, fecha_carrito, total_carrito) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $usuario_id, $personalizacion_id, $fecha, $precio_total);

        if ($stmt->execute()) {
            header("Location: ../pages/carrito.php");
            exit();
        } else {
            $_SESSION['error'] = "Hubo un problema al crear el pedido.";
            header("Location: ../pages/personalization.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Hubo un problema al insertar los datos de personalización.";
        header("Location: ../pages/personalization.php");
        exit();
    }
}

$conn->close();
