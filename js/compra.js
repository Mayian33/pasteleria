document.addEventListener('DOMContentLoaded', () => {
    const addToCartBtn = document.querySelector('#add-to-cart');
    const mensaje = document.getElementById('mensaje-usuario');

    function mostrarMensaje(texto, tipo = 'exito') {
        mensaje.textContent = texto;
        mensaje.className = `mensaje-usuario ${tipo}`;
        mensaje.style.display = 'block';
        setTimeout(() => {
            mensaje.style.display = 'none';
        }, 4000);
    }

    if (!addToCartBtn) return; // Evita errores si el botón no existe

    addToCartBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const isLoggedIn = document.getElementById('user-session')?.dataset.loggedIn === 'true';
        const productId = this.dataset.id;

        if (!isLoggedIn) {
            mostrarMensaje("Debes iniciar sesión para añadir productos al carrito.", 'error');
            return;
        }

        // Solo necesitas ESTE fetch si carritoinsert.php hace ambas cosas
fetch('../php/carritoinsert.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `producto_id=${productId}`
})
.then(response => response.json())
.then(data => {
    if (data.status === 'duplicado') {
        alert(data.message); // Solo alerta si ya existe
    } else if (data.status === 'ok') {
        window.location.href = '../pages/carrito.php'; // Redirige sin mostrar mensaje
    } else {
        alert(data.message || "Ocurrió un error inesperado.");
    }
})
.catch(() => {
    alert("Error de conexión con el servidor.");
});

    });
});
