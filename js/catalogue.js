window.addEventListener('load', () => {
    const hash = window.location.hash;
    if (hash) {
        const el = document.querySelector(hash);
        if (el) {
            setTimeout(() => {
                el.scrollIntoView({
                    behavior: 'smooth'
                });
            }, 100);
        }
    }
});

// borrar producto
function confirmarBorrado() {
    return confirm("¿Estás seguro que quieres borrar este producto?");
}
