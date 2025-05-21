<?php
session_start(); 

// Eliminar todas las variables de sesión
session_unset(); 

// Destruir la sesión
session_destroy(); 

// Eliminar la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');  // Expira la cookie
}

// Redirigir a la página principal (o donde quieras)
header("Location: ../pages/principal.php"); 
exit();
?>
