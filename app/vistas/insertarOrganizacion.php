<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar nueva organización</title>
    <link rel="stylesheet" href="web/css/estilosInsertarUsuario.css">
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
        <div class="form-container">
            <div class="form-section">
                <h1>Insertar Nueva Organización</h1>
                <?php if (!empty($error)): ?>
                    <p style="color:red;"><?= htmlentities($error) ?></p>
                <?php endif; ?>
                <form action="index.php?accion=registrarOrganizacion" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accessibility" value="<?php echo $_SESSION['accessibility'] ?>">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" placeholder="Escriba su nombre" required>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" name="descripcion" placeholder="Escriba su descripción" required>
                    <label for="sitioWeb">Sitio Web: (https://www.ejemplo.com)</label>
                    <input type="text" name="sitioWeb" placeholder="Escriba su sitio web" required>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" placeholder="Escriba su teléfono" required>
                    <label for="ciego">Ciego:</label>
                    <select name="ciego" id="ciego">
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Escriba su email" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" placeholder="Escriba su contraseña" required>
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" placeholder="Escriba su dirección" required>
                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" accept="image/jpeg, image/gif, image/webp, image/png" placeholder="inserte su foto de perfil">
                    <label for="rol">Rol:</label>
                    <input type="text" name="rol" value="Organización" readonly>

                    <input type="submit" value="Registrar" tabindex="0">
                </form>
            </div>
        </div>
        <div class="volver-container">
            <a href="index.php?accion=verTodasLasOrganizaciones" id="botonVolver">Volver</a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const accessibility = urlParams.get('accessibility');

            if (accessibility === 'yes') {
                var elementos = document.querySelectorAll('h1, label, input[type="text"], input[type="email"], input[type="password"], input[type="submit"], input[type="file"], select, option, a');

                function agregarEventos(elemento) {
                    elemento.addEventListener("mouseover", function(event) {
                        var texto = obtenerTexto(event.target);
                        hablarTexto(texto);
                    });

                    elemento.addEventListener("mouseout", function() {
                        detenerTexto();
                    });

                    elemento.addEventListener("focus", function(event) {
                        var texto = obtenerTexto(event.target);
                        hablarTexto(texto);
                    });

                    elemento.addEventListener("blur", function() {
                        detenerTexto();
                    });
                }

                elementos.forEach(agregarEventos);

                function obtenerTexto(elemento) {
                    var texto = elemento.innerText || elemento.value;
                    if (elemento.tagName === 'INPUT' && !elemento.value) {
                        texto = elemento.getAttribute('placeholder');
                    }
                    return texto;
                }

                function hablarTexto(texto) {
                    var voz = new SpeechSynthesisUtterance();
                    voz.text = texto;
                    window.speechSynthesis.speak(voz);
                }

                function detenerTexto() {
                    window.speechSynthesis.cancel();
                }
            }

            // Añadimos el parámetro accessibility al enlace de volver
            const botonVolver = document.getElementById('botonVolver');
            if (accessibility) {
                botonVolver.href = 'index.php?accion=verTodasLasOrganizaciones';
            } else {
                botonVolver.href = 'index.php?accion=verTodasLasOrganizaciones';
            }
        });
    </script>
</body>

</html>
