<?php
include_once('conexion.php');
session_start(); // Iniciar sesión para mostrar mensajes de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    // Validar si los campos están vacíos
    if (empty($Email) || empty($Password) || empty($Name)) {
        $_SESSION['error'] = "Por favor, ingresa todos los campos.";
        header("Location: registro.php");
        exit();
    }

    // Verificar si el email ya existe
    $sql = "SELECT email_usuario FROM usuarios WHERE email_usuario='$Email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "El email ya está registrado. Usa otro.";
        header("Location: registro.php");
        exit();
    }

    // Encriptar la contraseña
    $Pass = md5($Password);

    // Asignar el rol 2 (cliente) automáticamente
    $rol = 2;

    // Insertar el nuevo usuario en la base de datos con el rol asignado
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
