document.getElementById('add-to-cart').addEventListener('click', function(e) {
    const isLoggedIn = document.getElementById('user-session').dataset.loggedIn === 'true';
    const productId = this.dataset.id;

    if (!isLoggedIn) {
        alert("Por favor, inicia sesión para añadir productos al carrito.");
    } else {
        // Redirigir manualmente si el usuario está logueado
        window.location.href = `../php/carritoInsert.php?id=${productId}`;
    }
});