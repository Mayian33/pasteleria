function mostrarMensaje(texto, tipo) {
    const mensajeDiv = document.getElementById('mensaje');
    mensajeDiv.textContent = texto;
    mensajeDiv.style.display = "block";
    mensajeDiv.style.marginTop = "15px";
    mensajeDiv.style.padding = "10px";
    mensajeDiv.style.borderRadius = "5px";
    mensajeDiv.style.fontWeight = "bold";

    if (tipo === "error") {
        mensajeDiv.style.backgroundColor = "#f8d7da";
        mensajeDiv.style.color = "#721c24";
        mensajeDiv.style.border = "1px solid #f5c6cb";
    } else if (tipo === "exito") {
        mensajeDiv.style.backgroundColor = "#d4edda";
        mensajeDiv.style.color = "#155724";
        mensajeDiv.style.border = "1px solid #c3e6cb";
    }
}

function validarFormulario() {
    const sabor = document.getElementById('saborSelect').value;
    const masa = document.getElementById('masaSelect').value;
    const tamano = document.getElementById('tamanoSelect').value;
    const decoracion = document.getElementById('decoracionSelect').value;

    if (!sabor || !masa || !tamano || !decoracion) {
        mostrarMensaje("Por favor, selecciona todas las opciones antes de continuar.", "error");
        return false;
    }

    return true;
}

function redirigirComprar() {
    if (validarFormulario()) {
        mostrarMensaje("Formulario válido. Redirigiendo a comprar...", "exito");
    }
}

function redirigirAnadir() {
    if (validarFormulario()) {
        mostrarMensaje("Formulario válido. Añadiendo al carrito...", "exito");
    }
}


