<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
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
                <h1 class="subtitle title-midium">Crear cuenta</h1>

                <form action="registroInsert.php" method="post">

                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Registrarse</button>
                </form>

                <p>¿Ya tienes cuenta? <a class="login_option" href="login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</body>

</html>