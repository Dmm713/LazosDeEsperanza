<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Testimonio</title>
    <link rel="stylesheet" href="web/css/estilosNuevoTestimonio.css">
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
                    <h1>Crear Nuevo Testimonio</h1>
                </div>
                <!-- Botón para regresar a mis testimonios -->
                <div class="new-user-container">
                    <a href="index.php?accion=misTestimoniosOrganizacion" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
     
    <div class="form-container">
        <div id="preview"></div>
        <form action="index.php?accion=crearTestimonio" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required><br><br>

            <label for="problema">Problema:</label>
            <textarea id="problema" name="problema" required></textarea><br><br>

            <label for="solucion">Solución:</label>
            <textarea id="solucion" name="solucion" required></textarea><br><br>

            <label for="foto">Foto del Testimonio:</label>
            <input type="file" id="foto" name="foto" accept="image/*"><br><br>

            <div class="btn-container">
                <button type="submit">Crear Testimonio</button>
                <a href="index.php?accion=misTestimoniosOrganizacion" class="btn">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            var preview = document.getElementById('preview');
            var files = event.target.files;

            if (files.length > 0) {
                var file = files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Vista previa de la imagen">';
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
