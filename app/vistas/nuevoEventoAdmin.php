<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Evento</title>
    <link rel="stylesheet" href="web/css/estilosNuevoEvento.css">
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
                    <h1>Crear Nuevo Evento</h1>
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
        <div id="preview"></div>
        <form id="crearEventoForm" action="index.php?accion=crearEventoAdmin" method="post" enctype="multipart/form-data">
            <label for="idOrganizacion">Organización:</label>
            <select id="idOrganizacion" name="idOrganizacion" required>
                <?php foreach ($organizaciones as $organizacion): ?>
                    <option value="<?php echo $organizacion->getIdOrganizacion(); ?>"><?php echo $organizacion->getNombre(); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" ><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea><br><br>

            <label for="fechaEvento">Fecha del Evento:</label>
            <input type="date" id="fechaEvento" name="fechaEvento" required><br><br>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required><br><br>

            <label for="fotoEvento">Foto del Evento:</label>
            <input type="file" id="fotoEvento" name="fotoEvento" accept="image/jpeg, image/webp, image/png"><br><br>

            <button type="submit">Crear Evento</button>
        </form>
    </div>

    <script>
        document.getElementById('fotoEvento').addEventListener('change', function(event) {
            var preview = document.getElementById('preview');
            var files = event.target.files;

            if (files.length > 0) {
                var file = files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Vista previa de la imagen">';
                }

                reader.readAsDataURL(file);
            }
        });
    
        // Establecer la fecha mínima en el campo de fecha
        document.addEventListener('DOMContentLoaded', (event) => {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fechaEvento').setAttribute('min', today);
        });

        document.getElementById('crearEventoForm').addEventListener('submit', function(event) {
            const form = event.target;
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
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
                    var elementos = document.querySelectorAll('h1, h5, h3, h2, p, a, button , label, input, strong, ul, li, textarea');

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
