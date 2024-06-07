<!DOCTYPE html>
<html>
<head>
    <title>Crear Nuevo Evento</title>
</head>
<body>
    <h1>Crear Nuevo Evento</h1>
    <form action="index.php?accion=crearEvento" method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>

        <label for="fechaEvento">Fecha del Evento:</label>
        <input type="date" id="fechaEvento" name="fechaEvento" required><br><br>

        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" required><br><br>

        <label for="fotoEvento">Foto del Evento:</label>
        <input type="file" id="fotoEvento" name="fotoEvento" accept="image/*"><br><br>

        <button type="submit">Crear Evento</button>
    </form>
</body>
</html>
