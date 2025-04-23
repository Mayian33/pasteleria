<?php 
include_once 'conexion.php'; // Incluir el archivo de conexión a la base de datos

// Verificar si se enviaron las credenciales a través del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = $_POST['email'];
    $Password = md5($_POST['password']);  

    $Pass = md5($Password);

    // Consultar la base de datos para verificar el usuario
    $sql = "SELECT nombre_usuario, rol FROM usuarios WHERE email_usuario='$Email' AND password_usuario='$Password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si las credenciales son correctas, iniciar sesión
        $row = $result->fetch_assoc();
        $_SESSION['Name'] = $row['nombre_usuario'];
        $_SESSION['Id_Rol'] = $row['rol'];

        // Redirigir a la página principal
        header("Location: index.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, guardar el error en la sesión
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php"); // Redirigir al login
        exit();
    }
}
?>
