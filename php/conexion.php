<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "brollin");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables iniciales
$Sesion = '';
$Carrito = '';
$Pedido = '';
$rol = $_SESSION["rol"] ?? null;
$name = $_SESSION["nombre_usuario"] ?? '';
$email = $_SESSION["email_usuario"] ?? '';
$picture = $_SESSION["foto_usuario"] ?? '';

// Si está logueado


if (!empty($name)) {
    $Sesion = "
    <div class='user-info'>
        <label for='menu-toggle-account' class='account-label'>
            <img src=\"" . htmlspecialchars($picture) . "\" alt='Foto de perfil' class='profile-img'>
            <span class='common-text'>" . htmlspecialchars($name) . "</span>
        </label>
        <input type='checkbox' id='menu-toggle-account' class='menu-toggle-account'>
        <div class='dropdown-menu'>
            <a class='common-text' href='../pages/carrito.php'>Ver Carrito <img src='../assets/img/icons/carrito.png' alt='Carrito' class='icono-carrito'> </a>
            <a class='common-text' href='../php/cerrarsesion.php'>Cerrar sesión <img src='../assets/img/icons/salida.png' alt='Carrito' class='icono-cerrar'> </a>
        </div>
    </div>";
} else {
    $Sesion = '<a class="cta-btn btn-menu" href="../php/callback.php"><span>Iniciar sesión</span> <img class="icono-carrito" src="../assets/img/icons/ingresar.png" alt="Icono de sesion"></a>';
}


// Elementos solo para cliente (rol 2)
$ClienteMenu = '';
if ($rol == 2 || empty($rol)) {
    $ClienteMenu = '
        <a href="./index.php">Home</a>
        <a href="#sobremi">Sobre mi</a>
        <a href="./catalogue.php">Catalogo</a>
        <a href="./personalization.php">Personalización</a>
    ';
}

// Menú completo
$Menu = '
    <div class="navbar" id="home">
        <nav>
            <div class="logo">
                <img alt="logo" src="../assets/img/logos/logo_menu.png" />
            </div>
            <div class="menu-toggle-account" onclick="toggleMenu()">☰</div>
            <nav class="nav">
                ' . $ClienteMenu . $Pedido . '
                <a href="../pages/reseñas.php">Reseñas</a>
                <a href="#">Contacto</a>
                <a href="../pages/stock.php">Stock</a>
                        <a href="./catalogue.php">Catalogo</a>
            </nav>
            <div class="right-menu">
                ' . $Carrito  . $Sesion . '
            </div>
        </nav>
    </div>
';
