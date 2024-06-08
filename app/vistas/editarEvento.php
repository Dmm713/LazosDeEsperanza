<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Evento</title>
    <link rel="stylesheet" href="web/css/estilosNuevoEvento.css">
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

        h1 {
            text-align: center;
            color: #08929c;
        }

        /*-------------------------------------ESTILOS HEADER------------------------------------------------------------------------------------------------*/
        header {
            width: 100%;
            background-color: #00aab7;
            padding: 10px 20px;
            font-family: Changa;
            font-size: 20px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            /* Permite que los elementos se envuelvan en pantallas pequeñas */
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .title-container {
            flex: 2;
            text-align: center;
            color: white;
        }

        .new-user-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex: 1;
        }

        header h1 {
            margin: 0;
            color: white;
            font-size: 1.5em;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .btn {
            display: block;
            padding: 10px 20px;
            background-color: #014949;
            color: #7FF9B9;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #067a83;
        }

        /*--------------------------------------------------------------------------------------------------------------------------------------------------*/

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
        }

        .form-container img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto 10px;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-container .btn {
            display: inline-block;
            margin-right: 10px;
        }

        .btn-container .btn:last-child {
            margin-right: 0;
        }

        .btn {
            display: block;
            padding: 10px 20px;
            background-color: #014949;
            color: #7FF9B9;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #067a83;
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
                    <h1>Editar Evento</h1>
                </div>
                <!-- Botón para insertar un nuevo usuario -->
                <div class="new-user-container">
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary" style="margin-right: 80px;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="form-container">
        <?php if (!empty($evento->getFotoEvento())) : ?>
            <img id="outputImage" src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento">
        <?php else : ?>
            <img id="outputImage" style="display:none;" alt="Previsualización de la nueva foto">
        <?php endif; ?>
        <form id="editarEventoForm" action="index.php?accion=editarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idEvento" value="<?php echo htmlspecialchars($evento->getIdEvento()); ?>">
            <input type="hidden" name="fotoActual" value="<?php echo htmlspecialchars($evento->getFotoEvento()); ?>">

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($evento->getTitulo()); ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($evento->getDescripcion()); ?></textarea>

            <label for="fechaEvento">Fecha del Evento:</label>
            <input type="date" id="fechaEvento" name="fechaEvento" value="<?php echo htmlspecialchars($evento->getFechaEvento()); ?>" required>

            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" value="<?php echo htmlspecialchars($evento->getUbicacion()); ?>" required>

            <label for="fotoEvento">Foto del Evento:</label>
            <input type="file" id="fotoEvento" name="fotoEvento" accept="image/*" onchange="previewImage(event)">
        </form>
    </div>
    <div class="btn-container">
        <button type="submit" form="editarEventoForm" class="btn">Guardar Cambios</button>
        <a href="index.php?accion=misEventosOrganizacion" class="btn">Cancelar</a>
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

        // Establecer la fecha mínima en el campo de fecha
        document.addEventListener('DOMContentLoaded', (event) => {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('fechaEvento').setAttribute('min', today);
        });
    </script>
</body>

</html>
