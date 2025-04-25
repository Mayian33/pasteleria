function cambiarCantidad(btn, cambio) {
    const contenedor = btn.parentElement;
    const input = contenedor.querySelector('input');
    const numero = contenedor.querySelector('.cantidad-numero');
    let nuevaCantidad = parseInt(input.value) + cambio;
    if (nuevaCantidad < 1) nuevaCantidad = 1;
    input.value = nuevaCantidad;
    numero.textContent = nuevaCantidad;
}