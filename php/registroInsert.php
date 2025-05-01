<?php
include_once('conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    if (empty($Email) || empty($Password) || empty($Name)) {
        $_SESSION['error'] = "Por favor, ingresa todos los campos.";
        header("Location: registro.php");
        exit();
    }

    $sql = "SELECT email_usuario FROM usuarios WHERE email_usuario='$Email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "El email ya está registrado. Usa otro.";
        header("Location: registro.php");
        exit();
    }

    $Pass = md5($Password);

    $rol = 2;

    $sql = "INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario, rol) VALUES ('$Name','$Email', '$Pass', '$rol')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Cuenta creada con éxito. Ahora puedes iniciar sesión.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Error al registrar la cuenta. Intenta de nuevo.";
        header("Location: registro.php");
        exit();
    }
}
