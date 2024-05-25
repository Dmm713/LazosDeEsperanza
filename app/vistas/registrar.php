<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="web/css/estilosRegistrar.css">
</head>

<body>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>
<div class="content">
    <h1>Registro</h1>
    <?= $error ?>
    <form action="index.php?accion=registrar" method="POST" enctype="multipart/form-data">
        Nombre: <input type="text" name="nombre"><br>
        Apellidos:<input type="text" name="apellidos"><br>
        Direccion: <input type="text" name="direccion"><br>
        Ciego:
        <select name="ciego" id="ciego">
            <option value="SI">SI</option>
            <option value="NO">NO</option>
        </select>

        Email: <input type="email" name="email"><br>
        Contraseña: <input type="password" name="password"><br>
        Rol: 
        <select name="rol" id="rol">
            <option value="Usuario">Usuario</option>
            <option value="Organizacion">Organizacion</option>
        </select>
        Foto:<input type="file" name="foto" accept="image/jpeg, image/gif, image/webp, image/png"><br>
        <input type="submit" value="registrar">
        <a href="index.php">volver</a>
    </form>
</div>
</body>

</html>