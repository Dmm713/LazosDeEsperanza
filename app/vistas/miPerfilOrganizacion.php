<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Organización</title>
    <link rel="stylesheet" href="web/css/estilosMiPerfilOrganizacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
    <style>
      

    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <h2><?php echo htmlspecialchars($organizacion->getNombre()); ?></h2>
            <div class="profile-avatar">
                <img id="profileImage" src="web/fotosUsuarios/<?php echo htmlspecialchars($organizacion->getFoto()); ?>" alt="Foto de la organización">
                <div class="edit-icon">
                    <a href="#" id="editPhotoButton"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
            </div>
            <button style="color: #7FF9B9;" class="edit-btn" onclick="window.location.href='index.php?accion=editarMiPerfilOrganizacion&idOrganizacion=<?php echo $organizacion->getIdOrganizacion(); ?>'">Editar perfil</button>
        </div>
        <div class="profile-info">
            <label for="nombre">Nombre de la organización:</label>
            <span id="nombre"><?php echo htmlspecialchars($organizacion->getNombre()); ?></span><br>

            <label for="email">Email:</label>
            <span id="email"><?php echo htmlspecialchars($organizacion->getEmail()); ?></span><br>

            <label for="sitioWeb">Sitio Web:</label>
            <span id="sitioWeb"><?php echo htmlspecialchars($organizacion->getSitioWeb()); ?></span><br>

            <label for="telefono">Teléfono:</label>
            <span id="telefono"><?php echo htmlspecialchars($organizacion->getTelefono()); ?></span><br>

            <label for="direccion">Dirección:</label>
            <span id="direccion"><?php echo htmlspecialchars($organizacion->getDireccion()); ?></span><br>

            <label for="descripcion">Descripción:</label>
            <span id="descripcion"><?php echo htmlspecialchars($organizacion->getDescripcion()); ?></span><br>

            <label for="quienesSomos">Quiénes Somos:</label>
            <span id="quienesSomos"><?php echo htmlspecialchars($organizacion->getQuienesSomos()); ?></span><br>

            <label for="objetivos">Objetivos:</label>
            <span id="objetivos"><?php echo htmlspecialchars($organizacion->getObjetivos()); ?></span><br>

            <label for="ciudades">Ciudades:</label>
            <span id="ciudades"><?php echo htmlspecialchars($organizacion->getCiudades()); ?></span><br>
        </div>
        <button style="color: #7FF9B9;" class="save-btn" onclick="window.location.href='index.php?accion=paginaPrincipal&idOrganizacion=<?php echo $organizacion->getIdOrganizacion(); ?>'">Volver</button>
    </div>

    <!-- Modal -->
    <div id="editPhotoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Foto</h2>
            <form class="modal-form" id="editPhotoForm" action="index.php?accion=actualizarFoto&idOrganizacion=<?php echo $organizacion->getIdOrganizacion(); ?>" method="POST" enctype="multipart/form-data">
                <label for="nuevaFoto">Seleccione una nueva foto:</label>
                <input type="file" name="nuevaFoto" id="nuevaFoto" accept="image/jpeg, image/webp, image/png" required>
                <br><br>
                <input type="submit" value="Actualizar Foto">
            </form>
        </div>
    </div>

    <script>
        // Obtener el modal
        var modal = document.getElementById("editPhotoModal");

        // Obtener el enlace que abre el modal
        var btn = document.getElementById("editPhotoButton");

        // Obtener el <span> que cierra el modal
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario hace clic en el enlace, se abre el modal
        btn.onclick = function(event) {
            event.preventDefault();
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en <span> (x), se cierra el modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cuando el usuario hace clic en cualquier lugar fuera del modal, se cierra
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Manejar la actualización de la foto a través de AJAX
        document.getElementById('editPhotoForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', this.action, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.getElementById('profileImage').src = 'web/fotosUsuarios/' + response.foto;
                        modal.style.display = "none";
                    } else {
                        alert(response.error);
                    }
                } else {
                    alert('Error al actualizar la foto.');
                }
            };
            xhr.send(formData);
        });
    </script>
     <script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
                console.log(accessibility)
                if (accessibility === 'yes') {
                    var elementos = document.querySelectorAll('h1, h5, h3, h2, p, a, button , label, input, span');

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
