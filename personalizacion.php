<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personaliza Tu Tarta</title>
  <link rel="preload" href="css/index.css" as="style" />
  <link href="css/index.css" rel="stylesheet" />
</head>

<body>
  <div class="container">
    <!-- Título Principal -->
    <div class="content-card">
      <div class="text-content">
        <h1>¡Crea Tu Propia Tarta!</h1>
        <p>Elige los ingredientes, colores y decoración para diseñar tu tarta perfecta.</p>
      </div>
      <div class="image-content">
        <img src="tarta-inicial.jpg" alt="Tarta Inicial">
      </div>
    </div>

    <!-- Personalización de la tarta -->
    <div class="container-info">
      <div class="personalization-wrapper">
        <div class="personalization-content">
          <h2 class="subtitle-perso">Elige el Sabor</h2>
          <div class="cards-wrapper">
            <div class="card-wrapper">
              <div class="card-object card-1">
                <div class="face front">
                  <div class="title-wrapper">
                    <h3>Vainilla</h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-wrapper">
              <div class="card-object card-2">
                <div class="face front">
                  <div class="title-wrapper">
                    <h3>Chocolate</h3>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-wrapper">
              <div class="card-object card-3">
                <div class="face front">
                  <div class="title-wrapper">
                    <h3>Fresa</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="personalization-content">
          <h2 class="subtitle-perso">Elige el Color</h2>
          <div class="color-options">
            <label for="color-choice">Color del glaseado:</label>
            <input type="color" id="color-choice" name="color-choice" value="#f3b5a6">
          </div>
        </div>
      </div>

      <div class="personalization-content">
        <h2 class="subtitle-perso">Añade Decoración</h2>
        <div class="img-info">
          <img src="decoracion.jpg" alt="Decoración" class="img-personalization">
        </div>
        <div class="decoration-options">
          <label for="topping-choice">Elige un topping:</label>
          <select id="topping-choice">
            <option value="frutillas">Frutillas</option>
            <option value="chocolate">Chocolate</option>
            <option value="almendras">Almendras</option>
            <option value="caramelos">Caramelos</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Botón para finalizar la personalización -->
    <div class="footer-card">
      <div class="footer-info">
        <button class="btn-finalizar">Finalizar Personalización</button>
      </div>
    </div>
  </div>

  <script>
    document.querySelector('.btn-finalizar').addEventListener('click', function() {
      alert('¡Tu tarta ha sido personalizada!');
    });
  </script>
</body>

</html>
