<?php
session_start(); //Iniciar
session_unset(); //Borrar sesion
header("Location:login.php"); //Redireccion
exit();
?>
