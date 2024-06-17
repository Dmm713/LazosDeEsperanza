<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #014949;
        }

        form {
            width: 80%;
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #014949;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        select,
        input[type="file"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: rgb(38, 182, 167);
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #008080;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: white;
            background-color: rgb(38, 182, 167);
            padding: 10px;
            border-radius: 5px;
            width: 80%;
            max-width: 400px;
            margin: 10px auto;
        }

        a:hover {
            text-decoration: underline;
            background-color: #008080;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /*----------------------------------------------------------------FONDO EN MOVIMIENTO----------------------------------------------------------------------------*/

        html {
            height: 100%;
        }

        .bg {
            animation: slide 3s ease-in-out infinite alternate;
            background-image: linear-gradient(-60deg, #6c3 50%, #09f 50%);
            bottom: 0;
            left: -50%;
            opacity: .5;
            position: fixed;
            right: -50%;
            top: 0;
            z-index: -1;
        }

        .bg2 {
            animation-direction: alternate-reverse;
            animation-duration: 4s;
        }

        .bg3 {
            animation-duration: 5s;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: .25em;
            box-shadow: 0 0 .25em rgba(0, 0, 0, .25);
            box-sizing: border-box;
            padding: 10vmin;
            width: 70%;
            max-width: 800px;
            margin: auto;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .form-section {
            background-color: #014949;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .volver-container {
            margin-top: 20px;
            width: 100%;
            text-align: center;
        }

        @keyframes slide {
            0% {
                transform: translateX(-25%);
            }

            100% {
                transform: translateX(25%);
            }
        }

        /* Media Queries */
        @media (max-width: 1024px) {
            .form-container {
                flex-direction: column;
            }

            .form-section {
                margin-bottom: 20px;
                width: 80%;
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 5vmin;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="tel"],
            select,
            input[type="file"] {
                width: calc(100% - 20px);
                padding: 8px;
            }

            input[type="submit"] {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 24px;
            }

            .content {
                padding: 5vmin 3vmin;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="tel"],
            select,
            input[type="file"] {
                width: calc(100% - 16px);
                padding: 10px;
            }

            input[type="submit"] {
                padding: 14px;
            }

            a {
                width: calc(100% - 16px);
            }
        }
    </style>
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
        <div class="form-container">
            <h1>EDITAR USUARIO</h1>
            <div class="form-section">
                <?php if (isset($error) && !empty($error)) : ?>
                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form id="editarUsuarioForm" action="index.php?accion=editarMiPerfilUsuario&idUsuario=<?= htmlspecialchars($idUsuario) ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accessibility" value="<?= htmlspecialchars($_SESSION['accessibility']) ?>">
                    <input type="hidden" name="fotoTemporal" id="fotoTemporal" value="">
                    <div class="image-container">
                        <img id="preview" src="web/fotosUsuarios/<?= htmlspecialchars($usuario->getFoto()) ?>" alt="Foto de <?= htmlspecialchars($usuario->getNombre()) ?>">
                    </div>

                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario->getApellidos()) ?>" required>
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" value="<?= htmlspecialchars($usuario->getDireccion()) ?>" required>
                    <label for="ciego">Ciego:</label>
                    <select name="ciego" id="ciego">
                        <option value="SI" <?= $usuario->getCiego() == 'SI' ? 'selected' : '' ?>>SI</option>
                        <option value="NO" <?= $usuario->getCiego() == 'NO' ? 'selected' : '' ?>>NO</option>
                    </select>
                    <label for="rol">Rol:</label>
                    <input type="text" name="rol" value="<?= htmlspecialchars($usuario->getRol()) ?>" readonly>
                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" id="foto" accept="image/jpeg, image/webp, image/png">
                    <input type="submit" value="Editar Usuario">
                </form>
                <div class="volver-container">
                    <a href="index.php?accion=miPerfilUsuario" id="botonVolver">volver</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('foto').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('fotoTemporal').value = file.name;
                }
                reader.readAsDataURL(file);
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
