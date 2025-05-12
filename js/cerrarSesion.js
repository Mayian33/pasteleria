// Función para cerrar sesión
async function logout() {
  try {
    // 1. Revocar sesión de Google si está disponible
    if (typeof google !== 'undefined') {
      google.accounts.id.disableAutoSelect();
      const userEmail = localStorage.getItem('userEmail');
      if (userEmail) {
        google.accounts.id.revoke(userEmail);
      }
    }

    // 2. Limpiar el frontend
    localStorage.removeItem('userEmail');
    localStorage.removeItem('userToken');

    // 3. Llamar al endpoint PHP para cerrar sesión en el servidor
    const response = await fetch('../php/cerrarsesion.php', {
      method: 'POST',
      credentials: 'same-origin'
    });

    if (response.ok) {
      // 4. Redirigir al inicio o página de login
      window.location.href = '../pages/index.php';
    } else {
      console.error('Error al cerrar sesión en el servidor');
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

// Asignar evento al botón de logout
document.addEventListener('DOMContentLoaded', () => {
  const logoutButton = document.getElementById('logout-button');
  if (logoutButton) {
    logoutButton.addEventListener('click', logout);
  }
});