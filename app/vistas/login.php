<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="web/css/estilosLogin.css">
</head>
<body>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>
<div class="content">
    <p style="color: red;"><?= imprimirMensaje() ?></p>
    <div class="form-container">
        <form class="login-form" method="POST" action="index.php?accion=login">
            <h2>Iniciar Sesión Como Usuario</h2>
            <div class="error">
                <?php imprimirMensaje() ?>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Escribe tu email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Escribe tu contraseña" required>
            </div>
            <input type="hidden" name="accessibility" value="<?php echo $_SESSION['accessibility'] ?>">
            <input type="submit" value="Iniciar Sesión" tabindex="0">
        </form>
        <form class="login-form" method="POST" action="index.php?accion=loginOrganizacion">
            <h2>Iniciar Sesión Como Organización</h2>
            <div class="error">
                <?php imprimirMensaje() ?>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Escribe tu email" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Escribe tu contraseña" required>
            </div>
            <input type="hidden" name="accessibility" value="<?php echo $_SESSION['accessibility'] ?>">
            <input type="submit" value="Iniciar Sesión" tabindex="0">
        </form>
    </div>
    <div class="volver-container">
        <a href="index.php?accion=paginaPrincipal" id="botonVolver">volver</a>
    </div>
</div>
<script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
                console.log(accessibility)
                if (accessibility === 'yes') {
                    var elementos = document.querySelectorAll('h1, h5, h3, h2, p, a, button , label, input');

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
