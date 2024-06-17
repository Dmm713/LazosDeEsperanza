<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Testimonio</title>
    <link rel="stylesheet" href="web/css/estilosEditarTestimonio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo-container">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>
                <!-- Texto del Header -->
                <div class="title-container">
                    <h1>Editar Testimonio</h1>
                </div>
                <!-- Botón para volver a la lista de testimonios -->
                <div class="new-user-container">
                    <a href="index.php?accion=verTodosLosTestimoniosAdmin" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($testimonio->getFoto())) : ?>
            <img id="outputImage" src="web/fotosTestimonios/<?php echo htmlspecialchars($testimonio->getFoto()); ?>" alt="Foto del testimonio">
        <?php else : ?>
            <img id="outputImage" style="display:none;" alt="Previsualización de la nueva foto">
        <?php endif; ?>
        <form id="editarTestimonioForm" action="index.php?accion=editarTestimonioAdmin&idTestimonio=<?php echo $testimonio->getIdTestimonio(); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idTestimonio" value="<?php echo htmlspecialchars($testimonio->getIdTestimonio()); ?>">
            <input type="hidden" name="fotoActual" value="<?php echo htmlspecialchars($testimonio->getFoto()); ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($testimonio->getNombre()); ?>" >

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($testimonio->getApellidos()); ?>" required>

            <label for="problema">Problema:</label>
            <textarea id="problema" name="problema" maxlength="500" required><?php echo htmlspecialchars($testimonio->getProblema()); ?></textarea>

            <label for="solucion">Solución:</label>
            <textarea id="solucion" name="solucion" maxlength="500" required><?php echo htmlspecialchars($testimonio->getSolucion()); ?></textarea>

            <label for="foto">Foto del Testimonio:</label>
            <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">

            <div class="btn-container">
                <button type="submit" form="editarTestimonioForm" class="btn">Guardar Cambios</button>
                <a href="index.php?accion=verTodosLosTestimoniosAdmin" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('outputImage');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('editarTestimonioForm').addEventListener('submit', function(event) {
            const form = event.target;
            const problema = document.getElementById('problema').value;
            const solucion = document.getElementById('solucion').value;
            let errorMessage = '';

            if (problema.length > 500) {
                errorMessage = 'El campo "problema" no debe exceder los 500 caracteres.';
            }

            if (solucion.length > 500) {
                errorMessage = 'El campo "solución" no debe exceder los 500 caracteres.';
            }

            if (errorMessage) {
                event.preventDefault();
                const errorDiv = document.querySelector('.error-message');
                errorDiv.textContent = errorMessage;
                errorDiv.style.display = 'block';
            }
        });
    </script>
      <script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
                console.log(accessibility)
                if (accessibility === 'yes') {
                    var elementos = document.querySelectorAll('h1, h5, h2, p, a, button , label, input');

                    function agregarEventos(elemento) {
                        elemento.addEventListener("mouseover", function(event) {
                            hablarTexto(event.target.innerText);
                        });

                        elemento.addEventListener("mouseout", function() {
                            detenerTexto();
                        });

                        elemento.addEventListener("focus", function(event) {
                            hablarTexto(event.target.innerText);
                        });

                        elemento.addEventListener("blur", function() {
                            detenerTexto();
                        });
                    }

                    elementos.forEach(agregarEventos);

                    function hablarTexto(texto) {
                        var voz = new SpeechSynthesisUtterance();
                        voz.text = texto;
                        window.speechSynthesis.speak(voz);
                    }

                    function detenerTexto() {
                        window.speechSynthesis.cancel();
                    }
                }
            });

            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = urlParams.get('accessibility');
                const registerLink = document.getElementById('linkRegistrar');

                if (accessibility) {
                    registerLink.href += '&accessibility=' + accessibility;
                }
            });
        </script>
</body>

</html>
