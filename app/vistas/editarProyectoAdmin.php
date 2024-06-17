<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    <link rel="stylesheet" href="web/css/estilosEditarProyecto.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
        .error-message {
            color: red;
            font-weight: bold;
        }
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
                    <h1>Editar Proyecto</h1>
                </div>
                <!-- Botón para volver a la lista de proyectos -->
                <div class="new-user-container">
                    <a href="index.php?accion=verTodosLosProyectosAdmin" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <?php if (!empty($proyecto->getFotoProyecto())) : ?>
            <img id="outputImage" src="web/fotosProyectos/<?php echo htmlspecialchars($proyecto->getFotoProyecto()); ?>" alt="Foto del proyecto">
        <?php else : ?>
            <img id="outputImage" style="display:none;" alt="Previsualización de la nueva foto">
        <?php endif; ?>
        <form id="editarProyectoForm" action="index.php?accion=editarProyectoAdmin&idProyecto=<?php echo $proyecto->getIdProyecto(); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idProyecto" value="<?php echo htmlspecialchars($proyecto->getIdProyecto()); ?>">
            <input type="hidden" name="fotoActual" value="<?php echo htmlspecialchars($proyecto->getFotoProyecto()); ?>">

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($proyecto->getTitulo()); ?>" >

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" maxlength="500" required><?php echo htmlspecialchars($proyecto->getDescripcion()); ?></textarea>

            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo htmlspecialchars($proyecto->getFechaInicio()); ?>" required>

            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" value="<?php echo htmlspecialchars($proyecto->getFechaFin()); ?>" required>

            <label for="objetivoFinanciero">Objetivo Financiero (€):</label>
            <input type="number" id="objetivoFinanciero" name="objetivoFinanciero" maxlength="500" value="<?php echo htmlspecialchars($proyecto->getObjetivoFinanciero()); ?>" required>

            <label for="fotoProyecto">Foto del Proyecto:</label>
            <input type="file" id="fotoProyecto" name="fotoProyecto" accept="image/*" onchange="previewImage(event)">

            <div class="btn-container">
                <button type="submit" form="editarProyectoForm" class="btn">Guardar Cambios</button>
                <a href="index.php?accion=verTodosLosProyectosAdmin" class="btn">Cancelar</a>
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

        // Establecer la fecha mínima en los campos de fecha
        document.addEventListener('DOMContentLoaded', (event) => {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fechaInicio').setAttribute('min', today);
            document.getElementById('fechaFin').setAttribute('min', today);
        });

        document.getElementById('editarProyectoForm').addEventListener('submit', function(event) {
            const form = event.target;
            const descripcion = document.getElementById('descripcion').value;
            const objetivoFinanciero = document.getElementById('objetivoFinanciero').value;
            let errorMessage = '';

            if (descripcion.length > 500) {
                errorMessage = 'El campo "descripción" no debe exceder los 500 caracteres.';
            }

            if (objetivoFinanciero.length > 500) {
                errorMessage = 'El campo "objetivo financiero" no debe exceder los 500 caracteres.';
            }

            if (errorMessage) {
                event.preventDefault();
                const errorDiv = document.querySelector('.error-message');
                errorDiv.textContent = errorMessage;
                errorDiv.style.display = 'block';
            }
        });
    </script>
</body>

</html>
