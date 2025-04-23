<?php
// Iniciar la sesión para mostrar los errores
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos-comunes.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <header>
        <img src="./assets/img/logos/logo_menu.png" alt="logo" class="logo" />
    </header>

    <div class="form-container">
        <div class="form-content">
            <img src="./assets/img/principal/principal-img.jpg" alt="image-login" class="image-login" />
            <div class="form-login">
                <h1 class="subtitle title-midium">Iniciar sesión</h1>
                <h2 class="text-midium">Login</h2>

                <!-- Mostrar mensaje de error si existe -->
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<p class="error_message">' . $_SESSION['error'] . '</p>';
                    unset($_SESSION['error']);  // Limpiar el mensaje después de mostrarlo
                }
                ?>

                <form action="loginInsert.php" method="post">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit" class="cta-btn text">Iniciar sesión</button>
                </form>

                <p>¿No tienes cuenta? <a class="log_option" href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</body>

</html>
