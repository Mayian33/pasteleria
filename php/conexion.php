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
$ExtraMenu = '';
$rol = $_SESSION["rol"] ?? null;
$name = $_SESSION["nombre_usuario"] ?? '';
$email = $_SESSION["email_usuario"] ?? '';
$picture = $_SESSION["foto_usuario"] ?? '';


// Si está logueado
if (!empty($name)) {
    // PORQUE HAY 2 BOTONES DE CERRAR SESION??????????
    $Sesion = '<a class="cta-btn btn-menu" href="../php/cerrarsesion.php">Cerrar sesión</a>';

    // Mostrar carrito solo si no es admin
    if ($rol != 1) {
        $Carrito = '<a class="cta-btn btn-menu" href="../pages/carrito.php"><img src="../assets/img/icons/carrito.png" alt="Carrito"></a>';
    }

    // Opción solo para admin
    if ($rol == 1) {
        $ExtraMenu = '<a class="cta-btn btn-menu" href="../pages/orders.php">Ver Pedidos</a>';
    }

    // Mostrar foto (Google)
    $Sesion = "<div class='user-info'>
    <a class='cta-btn btn-menu' href='../php/cerrarsesion.php'>Cerrar sesión</a>
    <img src=\"" . htmlspecialchars($picture) . "\" alt='Foto de perfil' class='profile-img'>
</div>";
} else {
    $Sesion = '<a class="cta-btn btn-menu" href="../php/callback.php"><span>Iniciar sesión</span> <img class="icono-carrito" src="../assets/img/icons/login.png" alt="Icono de sesion"></a>';
}

// Menú completo
$Menu = '
    <div class="navbar" id="home">
        <nav>
            <div class="logo">
                <img alt="logo" src="../assets/img/logos/logo_menu.png" />
            </div>
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
            <nav class="nav">
                <a href="./index.php">Home</a>
                <a href="#sobremi">Sobre mi</a>
                <div class="dropdown">
                </div>
                <a href="./catalogue.php">Catalogo</a>
                <a href="#">Reseñas</a>
                <a href="./personalization.php">Personalización</a>
                <a href="#">Contacto</a>
                '   . $ExtraMenu . $Carrito .  $Sesion . '
            </nav>
        </nav>
    </div>
';
