<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión solo si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brollin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Inicializar variables
$Exist = false;
$Name = "";
$Cerrar = "";
$Menu = '';

// Asignar el rol en base a la sesión
if (isset($_SESSION["rol"])) {
    switch ($_SESSION["rol"]) {
        case 1:
            $Rol_trab = "Admin";
            break;
        case 2:
            $Rol_trab = "Cliente";
            break;
        default:
            $Rol_trab = "Invitado"; // Opción por defecto
            break;
    }
}

// Verificar si existe un nombre en la sesión
if (isset($_SESSION["Name"]) && $_SESSION["Name"] != "") {
    $Exist = true;
    $Name = $_SESSION["Name"];
    $Cerrar = '<a class="cta-btn btn-menu nav-link" href="cerrarsesion.php">Cerrar sesión</a>'; // Si está logueado, mostrar Cerrar sesión
} else {
    // Si no está logueado, mostrar el enlace de Iniciar sesión
    $Cerrar = '<a class="cta-btn btn-menu nav-link" href="login.php">Iniciar sesión <img src="./assets/img/icons/login.png" alt="Icono de usuario" class="icono"></a>';
}

// Menú dinámico
$Menu = '
    <div class="navbar" id="home">
        <nav>
            <div class="logo">
                <img alt="logo" src="./assets/img/logos/logo_menu.png" />
            </div>
            <!-- Botón de Menú Hamburguesa (solo visible en móviles) -->
            <div class="menu-toggle" onclick="toggleMenu()">☰</div>
            <!-- Menú de navegación -->
            <nav class="nav">
                <a href="./index.php">Home</a>
                <a href="#sobremi">Sobre mi</a>
                <div class="dropdown">
                    <a href="#">Pastelería</a>
                    <div class="dropdown-content">
                        <a href="#">Pastelería Salada</a>
                        <a href="#">Pastelería dulce</a>
                        <a href="#">Tartas</a>
                    </div>
                </div>
                <a href="./catalogue.php">Catalogo</a>
                <a href="#">Reseñas</a>
                <a href="./personalization.php">Personalización</a>
                <a href="#">Contacto</a>
                <!-- Aquí se agrega el botón de Iniciar sesión o Cerrar sesión dependiendo del estado -->
                ' . $Cerrar . '
            </nav>
        </nav>
    </div>
';
?>
