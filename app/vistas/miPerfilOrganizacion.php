<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de la Organización</title>
    <link rel="stylesheet" href="web/css/estilosMiPerfilOrganizacion.css">
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <h2>Nombre de la Organización</h2>
            <a href="#">Cambiar la contraseña</a>
        </div>
        <div class="profile-avatar">
            <img src="web/fotosProyectos/<?php echo htmlspecialchars($proyecto->getFotoProyecto()); ?>"alt="Foto de la organización">
            <div class="edit-icon">
                <img src="ruta/a/icono-de-editar.png" alt="Editar foto">
            </div>
        </div>
        <div class="profile-info">
            <label for="nombre">Nombre de la organización:</label>
            <span id="nombre">XXXXXX</span><br>

            <label for="email">Email:</label>
            <span id="email">XXXXXX@XXXXX.XXX</span><br>

            <label for="sitioWeb">Sitio Web:</label>
            <span id="sitioWeb">www.organizacion.com</span><br>

            <label for="telefono">Teléfono:</label>
            <span id="telefono">123-456-7890</span><br>

            <label for="direccion">Dirección:</label>
            <span id="direccion">Calle Falsa 123, Ciudad</span><br>

            <label for="descripcion">Descripción:</label>
            <span id="descripcion">Esta es una descripción de la organización.</span><br>
        </div>
        <button class="save-btn">Guardar</button>
    </div>
</body>
</html>
