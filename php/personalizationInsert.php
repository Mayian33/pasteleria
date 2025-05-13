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

    // Calcular precio total (aunque ya no se guarda en carrito)
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

    // Insertar en tabla personalizacion
    $stmt = $conn->prepare("INSERT INTO personalizacion (
        usuario_personalizacion, sabor_personalizacion, masa_personalizacion, tamano_personalizacion, 
        decoracion_personalizacion, fecha_personalizacion, precio_personalizacion, imagen_personalizacion) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiisds", $usuario_id, $sabor, $masa, $tamano, $decoracion, $fecha, $precio_total, $imagen);

    if ($stmt->execute()) {
        $personalizacion_id = $conn->insert_id;

        // Opciones adicionales
        if (isset($_POST['opciones']) && is_array($_POST['opciones'])) {
            foreach ($_POST['opciones'] as $nombre_opcion) {
                $stmt_op = $conn->prepare("SELECT opcion_id FROM opciones WHERE nombre_opcion = ?");
                $stmt_op->bind_param("s", $nombre_opcion);
                $stmt_op->execute();
                $result = $stmt_op->get_result();
                if ($row = $result->fetch_assoc()) {
                    $id_opcion = $row['opcion_id'];
                    $stmt_insert_op = $conn->prepare("INSERT INTO opciones_adicionales (id_personalizacion, id_opcion) VALUES (?, ?)");
                    $stmt_insert_op->bind_param("ii", $personalizacion_id, $id_opcion);
                    $stmt_insert_op->execute();
                    $stmt_insert_op->close();
                }
                $stmt_op->close();
            }
        }

        // Insertar en carrito (sin total ni cantidad)
        $producto_id = NULL;
        $stmt = $conn->prepare("INSERT INTO carrito (usuario_carrito, producto_id, personalizacion_id, fecha_carrito) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $usuario_id, $producto_id, $personalizacion_id, $fecha);

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
