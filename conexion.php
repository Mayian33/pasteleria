<?php
error_reporting(E_ALL);
ini_set('diaplay_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brollin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$Menu =
    '        <div class="navbar" id="home">
            <nav>
                <div class="logo">
                    <img alt="logo" src="./assets//img/logos/logo_menu.png" />
                </div>
                <!-- Botón de Menú Hamburguesa (solo visible en móviles) -->
                <div class="menu-toggle" onclick="toggleMenu()">☰</div>
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
                    <a href="#personalizacion">Personalizacion</a>
                    <a href="#">Contacto</a>
                </nav>
                <a class="cta-btn btn-menu" href="./login.php">
                    Iniciar sesión
                </a>
            </nav>
        </div>';
