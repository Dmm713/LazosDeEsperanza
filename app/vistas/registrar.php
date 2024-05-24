<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registro</h1>
    <?= $error ?>
    <form action="index.php?accion=registrar" method="post" enctype="multipart/form-data">
        Nombre: <input type="text" name="nombre"><br>
        Apellidos:<input type="text" name="apellidos"><br>
        Direccion: <input type="text" name="direccion"><br>
        Ciego: <input type="text" name="ciego"><br>
        Email: <input type="email" name="email"><br>
        Contraseña: <input type="password" name="password"><br>
        Rol: <input type="text" name="rol"><br>
        Foto:<input type="file" name="foto" accept="image/jpeg, image/gif, image/webp, image/png"><br>
        <input type="submit" value="registrar">
        <a href="index.php">volver</a>
    </form>
</body>
</html>