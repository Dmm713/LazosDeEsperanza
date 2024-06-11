<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="web/css/estilosMiPerfilUsuario.css">
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
        <div class="form-container">
            <h1 style="text-align: center;">EDITAR USUARIO</h1>
            <div class="form-section">
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="error-message" style="color: red;"><?= htmlspecialchars($error) ?></div>
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
                    <input type="submit" value="Editar Usuario" tabindex="0">
                </form>
                <div class="volver-container">
                    <a href="index.php?accion=miPerfilUsuario" id="botonVolver">volver</a>
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
                        document.getElementById('fotoTemporal').value = data.foto;
                    } else {
                        alert(data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
