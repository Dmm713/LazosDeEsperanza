<!DOCTYPE html>
<html>
<head>
    <title>Editar Evento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #08929c;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #08929c;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover {
            background-color: #067a83;
        }
    </style>
</head>
<body>
    <h1>Editar Evento</h1>
    <div class="form-container">
        <?php if (!empty($evento->getFotoEvento())): ?>
            <img src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento">
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
            <input type="file" id="fotoEvento" name="fotoEvento" accept="image/*">
        </form>
    </div>
    <div class="btn-container">
        <button type="submit" form="editarEventoForm" class="btn">Guardar Cambios</button>
        <a href="index.php?accion=misEventosOrganizacion" class="btn">Cancelar</a>
    </div>
</body>
</html>
