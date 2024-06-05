<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Organizacion</title>
    <link rel="stylesheet" href="web/css/estilosEditarUsuario.css">
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
        <div class="form-container">
            <h1 style="text-align: center;">EDITAR ORGANIZACIÓN</h1>
            <div class="form-section">
                <div class="error-message"><?= $error ?></div>
                <form id="editarOrganizacionForm" action="index.php?accion=editarOrganizacion&idOrganizacion=<?= $idOrganizacion ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="accessibility" value="<?php echo $_SESSION['accessibility'] ?>">
                    <div class="image-container">
                        <img id="preview" src="web/fotosUsuarios/<?= htmlspecialchars($organizacion->getFoto()) ?>" alt="Foto de <?= htmlspecialchars($organizacion->getNombre()) ?>">
                    </div>
                    <input type="hidden" name="fotoTemporal" id="fotoTemporal" value="">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?= $organizacion->getNombre() ?>" required>
                    <label for="descripcion">Descripcion:</label>
                    <input type="text" name="descripcion" value="<?= $organizacion->getDescripcion() ?>" required>
                    <label for="sitioWeb">Sitio Web:</label>
                    <input type="text" name="sitioWeb" value="<?= $organizacion->getSitioWeb() ?>" required>
                    <label for="telefono">Telefono:</label>
                    <input type="text" name="telefono" value="<?= $organizacion->getTelefono() ?>" required>
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" value="<?= $organizacion->getDireccion() ?>" required>
                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" id="foto" accept="image/jpeg, image/webp, image/png">
                    <label for="ciego">Ciego:</label>
                    <select name="ciego" id="ciego">
                        <option value="SI" <?= $organizacion->getCiego() == 'SI' ? 'selected' : '' ?>>SI</option>
                        <option value="NO" <?= $organizacion->getCiego() == 'NO' ? 'selected' : '' ?>>NO</option>
                    </select>
                    <label for="rol">Rol:</label>
                    <input type="text" name="rol" value="<?= $organizacion->getRol() ?>" readonly>
                    <input type="submit" value="Editar Usuario" tabindex="0">
                </form>
                <div class="volver-container">
                    <a href="index.php?accion=verTodasLasOrganizaciones" id="botonVolver">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <script>
       document.getElementById('foto').addEventListener('change', function() {
    var formData = new FormData();
    formData.append('foto', this.files[0]);

    fetch('index.php?accion=subirFotoAjax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error === '') {
                document.getElementById('preview').src = 'web/fotosUsuarios/' + data.foto;
                document.getElementById('fotoTemporal').value = data.foto; // Guardar el nombre de la foto temporal
            } else {
                alert(data.error);
            }
        })
        .catch(error => console.error('Error:', error));
});

    </script>
</body>

</html>