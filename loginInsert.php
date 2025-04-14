<?php
include_once('conexion.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    if (empty($Email) || empty($Password)) {
        $_SESSION['error'] = "Por favor, ingresa tu email y contraseña.";
        header("Location: login.php");
        exit();
    }

    $Pass = md5($Password);

    $sql = "SELECT nombre_usuario, rol FROM usuarios WHERE email_usuario='$Email' AND password_usuario='$Pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['Nombre'] = $row['nombre_usuario'];
        $_SESSION['Id'] = $row['rol'];

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Email o contraseña incorrectos. Inténtalo de nuevo.";
        header("Location: login.php");
        exit();
    }
}
?>
