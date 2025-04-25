document.addEventListener("DOMContentLoaded", function () {
    // Obtener el atributo data-logged-in para saber si el usuario está logueado
    const isLoggedIn = document.getElementById('user-session').getAttribute('data-logged-in');

    // Obtener el id del producto desde el URL (por si necesitas pasarlo al carrito)
    const productId = new URLSearchParams(window.location.search).get('id');

    // Si no está logueado, mostrar el modal al hacer clic en "Añadir al carrito"
    const addToCartBtn = document.getElementById('add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function (e) {
            if (isLoggedIn === 'false') {
                // Mostrar modal si no está logueado
                document.getElementById('login-modal').style.display = 'flex';
            } else {
                // Si está logueado, redirigir al carrito con el id del producto
                window.location.href = `carrito.php?id_prod=${productId}`;
            }
        });
    }

    // Cerrar el modal cuando se haga clic en la X
    document.getElementById('close-modal').addEventListener('click', function () {
        document.getElementById('login-modal').style.display = 'none';
    });

    // Acción al hacer clic en "Sí, iniciar sesión" - Redirigir al login
    document.getElementById('go-to-login').addEventListener('click', function () {
        window.location.href = 'login.php'; // Redirigir a la página de login
    });

    // Acción al hacer clic en "No, gracias" - Cerrar el modal
    document.getElementById('cancel-login').addEventListener('click', function () {
        document.getElementById('login-modal').style.display = 'none';
    });
});
