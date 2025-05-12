document.addEventListener('DOMContentLoaded', () => {
  function actualizarTotal() {
    let total = 0;

    document.querySelectorAll('.producto').forEach(producto => {
      const cantidadEl = producto.querySelector('.cantidad-numero');
      const precioEl = producto.querySelector('.precio');

      if (cantidadEl && precioEl) {
        const cantidad = parseInt(cantidadEl.textContent);
        const precioUnitario = parseFloat(precioEl.textContent.replace('€', '').replace(',', '.'));
        total += cantidad * precioUnitario;
      }
    });

    const totalEl = document.querySelector('.total');
    if (totalEl) {
      totalEl.textContent = `Total: €${total.toFixed(2)}`;
    }
  }

function guardarCantidadEnSesion(idCarrito, cantidad) {
  fetch('../php/actualizar_carrito.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `id_carrito=${idCarrito}&cantidad=${cantidad}`
  });
}


  document.querySelectorAll('.producto').forEach(producto => {
    const restarBtn = producto.querySelector('.restar');
    const sumarBtn = producto.querySelector('.sumar');
    const cantidadEl = producto.querySelector('.cantidad-numero');
    const inputHidden = producto.querySelector('input[type="hidden"]');
    const cantidadDiv = producto.querySelector('.cantidad');
    const idCarrito = cantidadDiv?.dataset.id;

    if (restarBtn && sumarBtn && cantidadEl && inputHidden && idCarrito) {
      restarBtn.addEventListener('click', () => {
        let cantidad = parseInt(cantidadEl.textContent);
        if (cantidad > 1) {
          cantidad--;
          cantidadEl.textContent = cantidad;
          inputHidden.value = cantidad;
          actualizarTotal();
          guardarCantidadEnSesion(idCarrito, cantidad);
        }
      });

      sumarBtn.addEventListener('click', () => {
        let cantidad = parseInt(cantidadEl.textContent);
        cantidad++;
        cantidadEl.textContent = cantidad;
        inputHidden.value = cantidad;
        actualizarTotal();
        guardarCantidadEnSesion(idCarrito, cantidad);
      });
    }
  });

  actualizarTotal(); // Inicial
});

function guardarCantidadEnSesion(idCarrito, cantidad) {
  fetch('../php/actualizar_cantidad.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `id_carrito=${idCarrito}&cantidad=${cantidad}`
  })
  .then(res => res.json())
  .then(data => console.log("Sesión actualizada:", data))
  .catch(err => console.error("Error actualizando sesión:", err));
}

