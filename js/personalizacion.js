
function validarFormulario() {
    const sabor = document.getElementById('saborSelect').value;
    const masa = document.getElementById('masaSelect').value;
    const tamano = document.getElementById('tamanoSelect').value;
    const decoracion = document.getElementById('decoracionSelect').value;

    if (!sabor || !masa || !tamano || !decoracion) {
        alert("Por favor, selecciona todas las opciones antes de continuar.");
        return false;
    }

    return true;
}

function redirigirComprar() {
    if (validarFormulario()) {
        alert("Formulario válido. Redirigiendo a comprar...");
    }
}

function redirigirAnadir() {
    if (validarFormulario()) {
        alert("Formulario válido. Añadiendo al carrito...");
    }
}

