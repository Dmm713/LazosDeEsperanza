<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="web/css/estilosMiPerfilUsuario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <h2><?php echo htmlspecialchars($usuario->getNombre()); ?></h2>
            <div class="profile-avatar">
                <img id="profileImage" src="web/fotosUsuarios/<?php echo htmlspecialchars($usuario->getFoto()); ?>" alt="Foto del usuario">
                <div class="edit-icon">
                    <a href="#" id="editPhotoButton"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
            <button style="color: #7FF9B9;" class="edit-btn" onclick="window.location.href='index.php?accion=editarMiPerfilUsuario&idUsuario=<?php echo $usuario->getIdUsuario(); ?>'">Editar perfil</button>
        </div>
        <div class="profile-info">
            <label for="nombre">Nombre:</label>
            <span id="nombre"><?php echo htmlspecialchars($usuario->getNombre()); ?></span><br>

            <label for="apellidos">Apellidos:</label>
            <span id="apellidos"><?php echo htmlspecialchars($usuario->getApellidos()); ?></span><br>

            <label for="email">Email:</label>
            <span id="email"><?php echo htmlspecialchars($usuario->getEmail()); ?></span><br>

            <label for="direccion">Dirección:</label>
            <span id="direccion"><?php echo htmlspecialchars($usuario->getDireccion()); ?></span><br>

            <label for="ciego">Ciego:</label>
            <span id="ciego"><?php echo htmlspecialchars($usuario->getCiego()); ?></span><br>

            <label for="rol">Rol:</label>
            <span id="rol"><?php echo htmlspecialchars($usuario->getRol()); ?></span><br>
        </div>
        <button style="color: #7FF9B9;" class="save-btn" onclick="window.location.href='index.php?accion=paginaPrincipal&idUsuario=<?php echo $usuario->getIdUsuario(); ?>'">Volver</button>
    </div>

    <!-- Modal -->
    <div id="editPhotoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Foto</h2>
            <form class="modal-form" id="editPhotoForm" action="index.php?accion=subirFotoAjax&idUsuario=<?php echo $usuario->getIdUsuario(); ?>" method="POST" enctype="multipart/form-data">
                <label for="nuevaFoto">Seleccione una nueva foto:</label>
                <input type="file" name="nuevaFoto" id="nuevaFoto" accept="image/jpeg, image/webp, image/png" required>
                <br><br>
                <input type="submit" value="Actualizar Foto">
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("editPhotoModal");
        var btn = document.getElementById("editPhotoButton");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function(event) {
            event.preventDefault();
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.getElementById('editPhotoForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('profileImage').src = 'web/fotosUsuarios/' + data.foto;
                    modal.style.display = "none";
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                alert('Error al actualizar la foto.');
                console.error('Error:', error);
            });
        });
    </script>
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
