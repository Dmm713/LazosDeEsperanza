<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Testimonio</title>
    <link rel="stylesheet" href="web/css/estilosEditarTestimonio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <!-- Logo -->
                <div class="logo-container">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>
                <!-- Texto del Header -->
                <div class="title-container">
                    <h1>Editar Testimonio</h1>
                </div>
                <!-- Botón para volver a la lista de testimonios -->
                <div class="new-user-container">
                    <a href="index.php?accion=misTestimoniosOrganizacion" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="form-container">
        <?php if (!empty($testimonio->getFoto())) : ?>
            <img id="outputImage" src="web/fotosTestimonios/<?php echo htmlspecialchars($testimonio->getFoto()); ?>" alt="Foto del testimonio">
        <?php else : ?>
            <img id="outputImage" style="display:none;" alt="Previsualización de la nueva foto">
        <?php endif; ?>
        <form id="editarTestimonioForm" action="index.php?accion=editarTestimonio&idTestimonio=<?php echo $testimonio->getIdTestimonio(); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idTestimonio" value="<?php echo htmlspecialchars($testimonio->getIdTestimonio()); ?>">
            <input type="hidden" name="fotoActual" value="<?php echo htmlspecialchars($testimonio->getFoto()); ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($testimonio->getNombre()); ?>" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($testimonio->getApellidos()); ?>" required>

            <label for="problema">Problema:</label>
            <textarea id="problema" name="problema" required><?php echo htmlspecialchars($testimonio->getProblema()); ?></textarea>

            <label for="solucion">Solución:</label>
            <textarea id="solucion" name="solucion" required><?php echo htmlspecialchars($testimonio->getSolucion()); ?></textarea>

            <label for="foto">Foto del Testimonio:</label>
            <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(event)">

            <div class="btn-container">
                <button type="submit" form="editarTestimonioForm" class="btn">Guardar Cambios</button>
                <a href="index.php?accion=misTestimoniosOrganizacion" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('outputImage');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
