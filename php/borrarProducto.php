<?php
session_start();
include_once('../php/conexion.php');

// Verifica si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../pages/catalogue.php");
    exit;
}

// Verifica si se ha recibido el id del producto
if (isset($_GET['id'])) {
    $id_prod = $_GET['id'];

    // Preparar la consulta para eliminar el producto
    $stmt = $conn->prepare("DELETE FROM productos WHERE id_prod = ?");
    $stmt->bind_param("i", $id_prod);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al catálogo después de eliminar el producto
        header("Location: ../pages/catalogue.php");
        exit;
    } else {
        // Error en la eliminación
        echo "Hubo un error al eliminar el producto.";
    }
} else {
    // Si no se recibe el id del producto
    header("Location: ../pages/catalogue.php");
    exit;
}
