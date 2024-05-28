<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="web/css/estilosRegistrar.css">
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
        <h1>Registro</h1>
        <?= $error ?>
        <form action="index.php?accion=registrar" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="accessibility" id="accessibility" value="<?= htmlentities($_GET['accessibility']) ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Escriba su nombre" required>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" placeholder="Escriba sus apellidos" required>
            <label for="direccion">Direccion:</label>
            <input type="text" name="direccion" placeholder="Escriba su direccion" required>
            <label for="ciego">Ciego:</label>
            <select name="ciego" id="ciego">
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Escriba su email" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" placeholder="Escriba su contraseña" required>
            <label for="rol">Rol:</label>
            <select name="rol" id="rol">
                <option value="Usuario">Usuario</option>
                <option value="Organizacion">Organizacion</option>
            </select>
            <label for="foto">Foto:</label>
            <input type="file" name="foto" accept="image/jpeg, image/gif, image/webp, image/png">
            <input type="submit" value="registrar" tabindex="0">
            <a href="#" id="botonVolver">volver</a>
        </form>
    </div>

    <script>
         document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const accessibility = urlParams.get('accessibility');

        if (accessibility === 'SI') {
            var elementos = document.querySelectorAll('h1, label, input[type="text"], input[type="email"], input[type="password"], input[type="submit"], input[type="file"] select, option, a');

            function agregarEventos(elemento) {
                elemento.addEventListener("mouseover", function (event) {
                    var texto = obtenerTexto(event.target);
                    hablarTexto(texto);
                });

                elemento.addEventListener("mouseout", function () {
                    detenerTexto();
                });

                elemento.addEventListener("focus", function (event) {
                    var texto = obtenerTexto(event.target);
                    hablarTexto(texto);
                });

                elemento.addEventListener("blur", function () {
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
            botonVolver.href = 'index.php?accion=paginaPrincipalRegistrar&accessibility=' + accessibility;
        } else {
            botonVolver.href = 'index.php?accion=paginaPrincipalRegistrar';
        }
    });
    </script>
</body>

</html>
