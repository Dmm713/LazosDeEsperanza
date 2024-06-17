<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="web/css/estilosEditarEvento.css">
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
                    <h1>Editar Evento</h1>
                </div>
                <!-- Botón para insertar un nuevo usuario -->
                <div class="new-user-container">
                    <a href="index.php?accion=verTodosLosEventosAdmin" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($evento->getFotoEvento())) : ?>
            <img id="outputImage" src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento">
        <?php else : ?>
            <img id="outputImage" style="display:none;" alt="Previsualización de la nueva foto">
        <?php endif; ?>
        <form id="editarEventoForm" action="index.php?accion=editarEventoAdmin&idEvento=<?php echo $evento->getIdEvento(); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idEvento" value="<?php echo htmlspecialchars($evento->getIdEvento()); ?>">
            <input type="hidden" name="fotoActual" value="<?php echo htmlspecialchars($evento->getFotoEvento()); ?>">

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($evento->getTitulo()); ?>" >

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($evento->getDescripcion()); ?></textarea>

            <label for="fechaEvento">Fecha del Evento:</label>
            <input type="date" id="fechaEvento" name="fechaEvento" value="<?php echo htmlspecialchars($evento->getFechaEvento()); ?>" required>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($evento->getUbicacion()); ?>" required>

            <label for="fotoEvento">Foto del Evento:</label>
            <input type="file" id="fotoEvento" name="fotoEvento" accept="image/*" onchange="previewImage(event)">

            <div class="btn-container">
                <button type="submit" form="editarEventoForm" class="btn">Guardar Cambios</button>
                <a href="index.php?accion=verTodosLosEventosAdmin" class="btn">Cancelar</a>
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

        // Establecer la fecha mínima en el campo de fecha
        document.addEventListener('DOMContentLoaded', (event) => {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fechaEvento').setAttribute('min', today);
        });

        document.getElementById('editarEventoForm').addEventListener('submit', function(event) {
            const form = event.target;
            const inputs = form.querySelectorAll('input[required], textarea[required]');
            let allFieldsFilled = true;

            inputs.forEach(input => {
                if (!input.value) {
                    allFieldsFilled = false;
                }
            });

            if (!allFieldsFilled) {
                event.preventDefault();
                const errorMessage = document.querySelector('.error-message');
                errorMessage.textContent = 'Todos los campos son obligatorios.';
                errorMessage.style.display = 'block';
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
