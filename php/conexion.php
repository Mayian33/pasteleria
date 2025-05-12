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
    // Comenzamos el contenido del dropdown
    $Sesion = "
    <div class='user-info'>
        <label for='menu-toggle-account' class='account-label'>
            <img src=\"" . htmlspecialchars($picture) . "\" alt='Foto de perfil' class='profile-img'>
            <span class='common-text'>" . htmlspecialchars($name) . "</span>
        </label>
        <input type='checkbox' id='menu-toggle-account' class='menu-toggle-account'>
        <div class='dropdown-menu'>";

    // Si es cliente o invitado (rol 2 o vacío), mostrar la opción de Carrito
    if ($rol == 2 || empty($rol)) {
        $Sesion .= "
            <a class='common-text' href='../pages/carrito.php'>Ver Carrito 
                <img src='../assets/img/icons/carrito.png' alt='Carrito' class='icono-carrito'>
            </a>";
    }

    // Mostrar siempre la opción de Cerrar sesión
    $Sesion .= "
       <a class='common-text' href='#' onclick='logoutGoogle()'>Cerrar sesión 
    <img src='../assets/img/icons/salida.png' alt='Cerrar' class='icono-cerrar'>
</a>
";

    // Cerrar div del dropdown
    $Sesion .= "
        </div>
    </div>";
} else {
    $Sesion = '<a class="cta-btn btn-menu" href="../php/callback.php"><span>Iniciar sesión</span> <img class="icono-carrito" src="../assets/img/icons/ingresar.png" alt="Icono de sesion"></a>';
}

// Menú para cliente/invitado
$ClienteMenu = '';
if ($rol == 2 || empty($rol)) {
    $ClienteMenu = '
        <a href="../pages/index.php">Home</a>
        <a href="../pages/catalogue.php">Catalogo</a>
        <a href="../pages/personalization.php">Personalización</a>
        <a href="../pages/donacion.php">Donaciones</a>
    ';
}

// Menú para admin
$AdminMenu = '';
if ($rol == 1) {
    $AdminMenu = '
     <a href="./orders.php">Pedidos</a>
        <a href="../pages/reseñas.php">Reseñas</a>
        <a href="../pages/stock.php">Stock</a>
        <a href="./catalogue.php">Catalogo</a>
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
                ' . $ClienteMenu . $AdminMenu . '
            </nav>
            <div class="right-menu">
                ' . $Carrito . $Sesion . '
            </div>
        </nav>
    </div>
';

$Footer = '
        <footer>
            <div class="footer-card">
                <div class="logo-footer">
                    <img src="../assets//img/logos/logo_menu.png" alt="logo">
                </div>

                <div class="footer-text">

                    <div class="frase common-text">
                        <p>Endulzando tus días con cada creación casera.</p>
                        <b>¡Gracias por confiar en nosotros!</b>
                    </div>
                </div>

                <div class="logos">
                    <img src="../assets/img/logos/instagram.png" alt="logo1">
                    <img src="../assets/img/logos/marker.png" alt="logo2">
                    <img src="../assets/img/logos/whatsapp.png" alt="logo3">
                </div>

                <div class="footer-info common-text">
                    <p>© 2025 - Bróllin | pasteleria</p>
                    <div class="footer-policies">
                     <a href="../pages/politica_privacidad.php">Política de Privacidad</a>
                        <a href="../pages/politicas_cookies.php">Política de Cookies</a>
                    </div>
                </div>
            </div>
        </footer>
';
?>


<!-- Esto va fuera de PHP -->
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
    const userEmail = "<?php echo $_SESSION['email_usuario'] ?? ''; ?>";
</script>
<script src="../js/logout.js" defer></script>



