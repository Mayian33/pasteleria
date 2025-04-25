<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = md5($_POST['password']);  // Solo una vez md5

    // Usamos prepare para evitar inyecciones SQL
    $sql = "SELECT id_usuario, nombre_usuario, rol FROM usuarios WHERE email_usuario='$Email' AND password_usuario='$Password'";

    $stmt = $conn->prepare($sql);  // Asegúrate de que esto sea preparado
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Guardar datos en la sesión
        $_SESSION['usuario_id'] = $row['id_usuario'];
        $_SESSION['Name'] = $row['nombre_usuario'];
        $_SESSION['Id_Rol'] = $row['rol'];

        // Redirigir al index (o a donde quieras)
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit();
    }
}
