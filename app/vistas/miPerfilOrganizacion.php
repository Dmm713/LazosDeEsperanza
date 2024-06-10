<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Organización</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 800px; /* Hacer la tarjeta más ancha */
            margin: 50px auto;
            padding: 20px;
            position: relative;
        }

        .profile-header {
            background-color: #00aab7;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-header h2 {
            margin: 0 0 10px 0;
            color: white;
        }

        .profile-avatar {
            position: relative;
            margin-bottom: 20px;
        }

        .profile-avatar img {
            border: 5px solid #00aab7; /* Borde del mismo color que la sección gris */
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: contain; /* Asegurarse de que la foto se vea completa */
            background-color: white;
        }

        .edit-icon {
            position: absolute;
            bottom: 10px; /* Colocarlo justo en el borde inferior de la imagen */
            right: 10px; /* Colocarlo a la derecha de la imagen */
            background-color: #e67e22; /* Fondo naranja */
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }

        .edit-icon:hover {
            background-color: #d35400; /* Fondo naranja más oscuro al pasar el ratón */
        }

        .edit-icon a {
            color: white;
            font-size: 14px;
            text-decoration: none;
        }

        .edit-icon a:hover {
            color: #fff;
        }

        .profile-info {
            text-align: left;
            margin-top: 20px;
        }

        .profile-info label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #08929c;
        }

        .profile-info span {
            display: block;
            margin-top: 5px;
            color: #333;
        }

        .save-btn {
            background-color: #014949;
            color: #7FF9B9;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .save-btn:hover {
            background-color: #067a83;
        }

        .edit-btn {
            background-color: #014949; /* Fondo naranja */
            color: #7FF9B9;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            position: absolute;
            bottom: 20px; /* Posicionarlo dentro de la parte gris */
            right: 20px;
            transition: background-color 0.3s;
        }

        .edit-btn:hover {
            background-color: #067a83;
        }

        /* Estilos para el modal */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.6); 
            padding-top: 60px;
            animation: modalFadeIn 0.3s;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto; 
            padding: 30px;
            border: 0;
            width: 90%;
            max-width: 500px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,.5);
            text-align: center;
            animation: modalSlideIn 0.5s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes modalSlideIn {
            from { transform: translateY(-50px); }
            to { transform: translateY(0); }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            margin-top: -10px;
            margin-right: -10px;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal h2 {
            margin-top: 0;
            color: #08929c;
            font-size: 24px;
        }

        .modal label {
            font-weight: bold;
            display: block;
            margin-top: 20px;
            color: #34495e;
        }

        .modal input[type="file"] {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
        }

        .modal input[type="submit"] {
            background-color: #014949;
            color: #7FF9B9;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .modal input[type="submit"]:hover {
            background-color: #067a83;
        }

        .modal input[type="submit"]:focus {
            outline: none;
            box-shadow: 0 0 10px #e67e22;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 10px;
            }

            .profile-header, .profile-info {
                padding: 10px;
                text-align: center;
            }

            .profile-avatar img {
                width: 120px;
                height: 120px;
                object-fit: contain; /* Asegurarse de que la foto se vea completa */
            }

            .profile-info label, .profile-info span {
                text-align: center;
            }

            .edit-btn {
                position: static;
                margin: 20px auto;
            }

            .save-btn {
                font-size: 14px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .profile-avatar {
                width: 100px;
                height: 100px;
                margin-bottom: 20px;
            }

            .profile-avatar img {
                width: 100%;
                height: 100%;
                object-fit: contain; /* Asegurar que la imagen se ajuste dentro del contenedor */
            }

            .edit-icon {
                bottom: 0; /* Colocar justo en el borde inferior de la imagen */
                right: 0; /* Colocar a la derecha de la imagen */
                padding: 5px;
                background-color: #e67e22; /* Fondo naranja */
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                transform: translate(50%, 50%); /* Asegurar que no tape la imagen */
            }

            .edit-icon img {
                width: 12px;
                height: 12px;
            }

            .edit-btn, .save-btn {
                font-size: 12px;
                padding: 8px;
            }
        }

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
            <button class="edit-btn" onclick="window.location.href='index.php?accion=editarOrganizacion&idOrganizacion=<?php echo $organizacion->getIdOrganizacion(); ?>'">Editar perfil</button>
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
        <button class="save-btn">Guardar</button>
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
</body>
</html>
