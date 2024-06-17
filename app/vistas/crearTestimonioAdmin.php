<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Testimonio</title>
    <link rel="stylesheet" href="web/css/estilosNuevoTestimonioAdmin.css">
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
                <div class="logo-container">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>
                <div class="title-container">
                    <h1>Crear Nuevo Testimonio</h1>
                </div>
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
        <div id="preview"></div>
        <form id="crearTestimonioForm" action="index.php?accion=crearTestimonioAdmin" method="post" enctype="multipart/form-data">
            <label for="idOrganizacion">Organización:</label>
            <select id="idOrganizacion" name="idOrganizacion" required>
                <option value="">Selecciona una organización</option>
                <?php foreach ($organizaciones as $organizacion): ?>
                    <option value="<?php echo $organizacion->getIdOrganizacion(); ?>">
                        <?php echo $organizacion->getNombre(); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" ><br><br>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required><br><br>

            <label for="problema">Problema:</label>
            <textarea id="problema" name="problema" maxlength="500" required></textarea><br><br>

            <label for="solucion">Solución:</label>
            <textarea id="solucion" name="solucion" maxlength="500" required></textarea><br><br>

            <label for="foto">Foto del Testimonio:</label>
            <input type="file" id="foto" name="foto" accept="image/*"><br><br>

            <div class="btn-container">
                <button type="submit">Crear Testimonio</button>
                <a href="index.php?accion=verTodosLosTestimoniosAdmin" class="btn">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
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

        document.getElementById('crearTestimonioForm').addEventListener('submit', function(event) {
            const form = event.target;
            const problema = document.getElementById('problema').value;
            const solucion = document.getElementById('solucion').value;
            let errorMessage = '';

            if (problema.length > 500 || solucion.length > 500) {
                errorMessage = 'El campo "problema" y "solución" no deben exceder los 500 caracteres.';
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
                    var elementos = document.querySelectorAll('h1, h5, h2, p, a, button , label, input, select, option');

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
