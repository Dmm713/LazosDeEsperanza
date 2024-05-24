<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sonido al abrir la página</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../web/css/estilosInicio.css">
  <style>
    
  </style>
</head>

<body>
  <header class="row">
    <img src="../../web/Images/lazos de esperanza Blanco.png" alt="logo" class="logo col-lg-2 col-md-2 col-sm-2 col-xs-12">
    <h1 id="parrafo1" class="parrafo col-lg-10 col-md-10 col-sm-10 col-xs-12" style="text-align: center; color: white;" tabindex="0">
      ¿Es usted una persona ciega? pulse el botón si o no en la pantalla
    </h1>
  </header>

  <div class="contenedor-enlaces">
    <a href="paginaPrincipal.php?accessibility=yes" id="parrafo2" class="parrafo">Sí</a>
    <a href="paginaPrincipal.php?accessibility=no" id="parrafo3" class="parrafo">No</a>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var elementos = document.querySelectorAll(".parrafo");

      // Función para agregar eventos de mouse y teclado
      function agregarEventos(elemento) {
        elemento.addEventListener("mouseover", function (event) {
          hablarTexto(event.target.innerText);
        });

        elemento.addEventListener("mouseout", function () {
          detenerTexto();
        });

        // Agregando eventos de foco para la navegación por teclado
        elemento.addEventListener("focus", function (event) {
          hablarTexto(event.target.innerText);
        });

        elemento.addEventListener("blur", function () {
          detenerTexto();
        });
      }

      // Recorriendo cada elemento para agregar los eventos
      elementos.forEach(agregarEventos);

      function hablarTexto(texto) {
        var voz = new SpeechSynthesisUtterance();
        voz.text = texto;
        window.speechSynthesis.speak(voz);
      }

      function detenerTexto() {
        window.speechSynthesis.cancel();
      }

      // Ejecutar automáticamente al cargar la página
      var parrafoInicial = document.getElementById("parrafo1").innerText;
      hablarTexto(parrafoInicial);
    });
  </script>
</body>

</html>
