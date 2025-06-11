document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('input[name="slider"]');
    let currentSlide = 0;
    const totalSlides = slides.length;

    function updateSlides() {
        document.querySelectorAll('.carrusel-card').forEach((card, index) => {
            // Mostrar solo la anterior, actual y siguiente
            if (
                index === currentSlide ||
                index === (currentSlide - 1 + totalSlides) % totalSlides ||
                index === (currentSlide + 1) % totalSlides
            ) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }

            // Reiniciar estilos base
            card.style.transform = 'translateX(40%) scale(0.8)';
            card.style.opacity = '0.4';
            card.style.zIndex = '0';
        });

        // Imagen actual (centro)
        const currentCard = document.querySelector(`#song-${currentSlide + 1}`);
        if (currentCard) {
            currentCard.style.transform = 'translateX(0) scale(1)';
            currentCard.style.opacity = '1';
            currentCard.style.zIndex = '1';
        }

        // Imagen anterior (izquierda)
        const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
        const prevCard = document.querySelector(`#song-${prevIndex + 1}`);
        if (prevCard) {
            prevCard.style.transform = 'translateX(-40%) scale(0.8)';
            prevCard.style.opacity = '0.4';
            prevCard.style.zIndex = '0';
        }

        // Imagen siguiente (derecha)
        const nextIndex = (currentSlide + 1) % totalSlides;
        const nextCard = document.querySelector(`#song-${nextIndex + 1}`);
        if (nextCard) {
            nextCard.style.transform = 'translateX(40%) scale(0.8)';
            nextCard.style.opacity = '0.4';
            nextCard.style.zIndex = '0';
        }
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        slides[currentSlide].checked = true;
        updateSlides();
    }

    // Inicializar
    updateSlides();

    // Avance automático cada 3 segundos
    let interval = setInterval(nextSlide, 3000);

    // Pausar al pasar el ratón
    const carrusel = document.querySelector('.carrusel-container');
    carrusel.addEventListener('mouseenter', () => clearInterval(interval));
    carrusel.addEventListener('mouseleave', () => interval = setInterval(nextSlide, 3000));
});
