<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrusel Automático</title>
    <style>
        * {
            box-sizing: border-box;
        }

        .carrusel-body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 10px;
            min-height: 100vh;
        }

        input[type=radio] {
            display: none;
        }

        .carrusel-container {
            width: 100%;
            max-width: 800px;
            transform-style: preserve-3d;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .carrusel-cards {
            position: relative;
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }

        .carrusel-card {
            position: absolute;
            width: 60%;
            height: 100%;
            left: 0;
            right: 0;
            margin: auto;
            transition: transform 0.4s ease, opacity 0.4s ease;
            cursor: pointer;
        }

        .carrusel-img {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
            transition: box-shadow 0.4s ease;
        }

        /* Efectos para las tarjetas laterales */
        #item-1:checked ~ .carrusel-container .carrusel-cards #song-3,
        #item-2:checked ~ .carrusel-container .carrusel-cards #song-1,
        #item-3:checked ~ .carrusel-container .carrusel-cards #song-2 {
            transform: translatex(-40%) scale(0.8);
            opacity: 0.4;
            z-index: 0;
        }

        #item-1:checked ~ .carrusel-container .carrusel-cards #song-2,
        #item-2:checked ~ .carrusel-container .carrusel-cards #song-3,
        #item-3:checked ~ .carrusel-container .carrusel-cards #song-1 {
            transform: translatex(40%) scale(0.8);
            opacity: 0.4;
            z-index: 0;
        }

        /* Efecto para la tarjeta central */
        #item-1:checked ~ .carrusel-container .carrusel-cards #song-1,
        #item-2:checked ~ .carrusel-container .carrusel-cards #song-2,
        #item-3:checked ~ .carrusel-container .carrusel-cards #song-3 {
            transform: translatex(0) scale(1);
            opacity: 1;
            z-index: 1;
        }

        /* Puntos de navegación */
        .carrusel-nav {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .carrusel-nav label {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ccc;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #item-1:checked ~ .carrusel-container .carrusel-nav label[for="item-1"],
        #item-2:checked ~ .carrusel-container .carrusel-nav label[for="item-2"],
        #item-3:checked ~ .carrusel-container .carrusel-nav label[for="item-3"] {
            background-color: #6a3093;
        }
    </style>
</head>
<body>
    <div class="carrusel-body">
        <input type="radio" name="slider" id="item-1" checked>
        <input type="radio" name="slider" id="item-2">
        <input type="radio" name="slider" id="item-3">
        
        <div class="carrusel-container">
            <div class="carrusel-cards">
                <label class="carrusel-card" for="item-1" id="song-1">
                    <img src="https://images.unsplash.com/photo-1530651788726-1dbf58eeef1f?ixlib=rb-1.2.1&auto=format&fit=crop&w=882&q=80" alt="Ciudad de noche" class="carrusel-img">
                </label>
                <label class="carrusel-card" for="item-2" id="song-2">
                    <img src="https://images.unsplash.com/photo-1559386484-97dfc0e15539?ixlib=rb-1.2.1&auto=format&fit=crop&w=1234&q=80" alt="Montañas" class="carrusel-img">
                </label>
                <label class="carrusel-card" for="item-3" id="song-3">
                    <img src="https://images.unsplash.com/photo-1533461502717-83546f485d24?ixlib=rb-1.2.1&auto=format&fit=crop&w=900&q=60" alt="Lago" class="carrusel-img">
                </label>
            </div>
            
            <div class="carrusel-nav">
                <label for="item-1"></label>
                <label for="item-2"></label>
                <label for="item-3"></label>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('input[name="slider"]');
            let currentSlide = 0;
            const totalSlides = slides.length;
            
            function nextSlide() {
                slides[currentSlide].checked = false;
                currentSlide = (currentSlide + 1) % totalSlides;
                slides[currentSlide].checked = true;
            }
            
            // Cambia de slide cada 3 segundos (3000ms)
            const interval = setInterval(nextSlide, 3000);
            
            // Pausa el carrusel cuando el mouse está sobre él
            const carrusel = document.querySelector('.carrusel-container');
            carrusel.addEventListener('mouseenter', () => clearInterval(interval));
            carrusel.addEventListener('mouseleave', () => interval = setInterval(nextSlide, 3000));
        });
    </script>
</body>
</html>