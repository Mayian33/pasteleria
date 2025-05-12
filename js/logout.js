function logoutGoogle() {
    google.accounts.id.disableAutoSelect();  // Desactiva la selección automática de cuenta

    const userEmail = "<?php echo $_SESSION['email_usuario'] ?? ''; ?>";  // Obtener el email de la sesión de PHP

    if (userEmail) {
        google.accounts.id.revoke(userEmail, done => {
            console.log("Revocación de sesión de Google completa");  // Verifica en la consola si se completó
            // Después de revocar, redirigimos a PHP para cerrar la sesión
            window.location.href = "../php/cerrarsesion.php";  
        });
    } else {
        // Si no hay un email, simplemente redirige a cerrar sesión
        window.location.href = "../php/cerrarsesion.php"; 
    }

    // Limpiar cookies y almacenamiento local
    localStorage.clear();  // Limpiar localStorage
    sessionStorage.clear();  // Limpiar sessionStorage
    document.cookie.split(";").forEach(function(c) {
        document.cookie = c.trim().split("=")[0] + "=;expires=" + new Date().toUTCString() + ";path=/";  // Eliminar cookies
    });
}
