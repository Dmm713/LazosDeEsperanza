<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Proyecto</title>
    <link rel="stylesheet" href="web/css/estilosNuevoProyectoAdmin.css">
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
                    <h1>Crear Nuevo Proyecto</h1>
                </div>
                <!-- Botón para regresar a mis proyectos -->
                <div class="new-user-container">
                    <a href="index.php?accion=verTodosLosProyectosAdmin" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
     
    <div class="form-container">
        <div id="preview"></div>
        <form action="index.php?accion=crearProyectoAdmin" method="post" enctype="multipart/form-data">
            <label for="idOrganizacion">Organización:</label>
            <select id="idOrganizacion" name="idOrganizacion" required>
                <option value="">Selecciona una organización</option>
                <?php foreach ($organizaciones as $organizacion): ?>
                    <option value="<?php echo $organizacion->getIdOrganizacion(); ?>">
                        <?php echo $organizacion->getNombre(); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea><br><br>

            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" required><br><br>

            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" required><br><br>

            <label for="objetivoFinanciero">Objetivo Financiero:</label>
            <input type="number" id="objetivoFinanciero" name="objetivoFinanciero" required><br><br>

            <label for="fotoProyecto">Foto del Proyecto:</label>
            <input type="file" id="fotoProyecto" name="fotoProyecto" accept="image/*"><br><br>

            <div class="btn-container">
                <button type="submit">Crear Proyecto</button>
                <a href="index.php?accion=verTodosLosProyectosAdmin" class="btn">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('fotoProyecto').addEventListener('change', function(event) {
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
    
        // Establecer la fecha mínima en los campos de fecha
        document.addEventListener('DOMContentLoaded', (event) => {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fechaInicio').setAttribute('min', today);
            document.getElementById('fechaFin').setAttribute('min', today);
        });
    </script>
</body>
</html>
