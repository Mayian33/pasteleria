document.addEventListener('DOMContentLoaded', () => {
    const addToCartBtn = document.querySelector('#add-to-cart');
    const btnDonar = document.getElementById('btn-donar'); // botón de donar
    const mensaje = document.getElementById('mensaje-usuario');

    // Añadir al carrito
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function (e) {
            e.preventDefault();

            const isLoggedIn = document.getElementById('user-session')?.dataset.loggedIn === 'true';
            const productId = this.dataset.id;

            if (!isLoggedIn) {
                alert("Debes iniciar sesión para añadir productos al carrito.");
                return;
            }

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
                        alert(data.message);
                    } else if (data.status === 'ok') {
                        window.location.href = '../pages/carrito.php';
                    } else {
                        alert(data.message || "Ocurrió un error inesperado.");
                    }
                })
                .catch(() => {
                    alert("Error de conexión con el servidor.");
                });
        });
    }

    // Donar producto
    if (btnDonar) {
        btnDonar.addEventListener('click', function () {
            const isLoggedIn = document.getElementById('user-session')?.dataset.loggedIn === 'true';
            const idProducto = this.dataset.id;

            // PRIMERO: alerta si no está logueado
            if (!isLoggedIn) {
                alert("Debes iniciar sesión para donar.");
                return;
            }

            // SOLO si está logueado, muestra el mensaje de confirmación
            const mensaje = "Vas a comprar este producto para ti.\nEl dinero será donado a una asociación solidaria.\n¿Deseas continuar?";
            if (confirm(mensaje)) {
                window.location.href = `../pages/stripe/donacion_producto.php?id=${idProducto}`;
            }
        });
    }


});
