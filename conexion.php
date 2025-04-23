<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$Exist = false;
$Name = "";
$Cerrar = "";

// Rol
$Rol_trab = "Invitado";
if (isset($_SESSION["rol"])) {
    $Rol_trab = ($_SESSION["rol"] == 1) ? "Admin" : (($_SESSION["rol"] == 2) ? "Cliente" : "Invitado");
}

// Usuario logueado
if (!empty($_SESSION["Name"])) {
    $Exist = true;
    $Name = $_SESSION["Name"];
    $Cerrar = '<a class="cta-btn btn-menu nav-link" href="cerrarsesion.php">Cerrar sesión</a>';
} else {
    $Cerrar = '<a class="cta-btn btn-menu nav-link" href="login.php">Iniciar sesión <img src="./assets/img/icons/login.png" alt="Icono de usuario" class="icono"></a>';
}

// Opcional: cerrar conexión si ya no la usas
// $conn->close();



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
