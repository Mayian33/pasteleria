<?php
session_start();
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = md5($_POST['password']);

    $sql = "SELECT id_usuario, nombre_usuario, rol FROM usuarios WHERE email_usuario='$Email' AND password_usuario='$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario_id'] = $row['id_usuario'];  // <-- esto es lo que necesitabas
        $_SESSION['Name'] = $row['nombre_usuario'];
        $_SESSION['rol'] = $row['rol'];

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit();
    }
}
