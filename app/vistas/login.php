<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="web/css/estilosLogin.css">
</head>
<body>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>
<div class="content">
    <p style="color: red;"><?= imprimirMensaje() ?></p>
    <form class="login-form" method="POST" action="index.php?accion=login">
        <h2>Iniciar Sesión Como Usuario</h2>
        <div class="error">
            <?php imprimirMensaje() ?>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Escribe tu contraseña" required>
        </div>
        <div class="input-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Escribe tu contraseña" required>
        </div>
        <input type="hidden" name="accessibility" value="<?php echo $_SESSION['accessibility'] ?>">
        <input type="submit" value="Iniciar Sesión" tabindex="0">
    </form>
    <form class="login-form" method="POST" action="index.php?accion=loginOrganizacion">
        <h2>Iniciar Sesión Como Organizacion</h2>
        <div class="error">
            <?php imprimirMensaje() ?>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" placeholder="Escribe tu email" required>
        </div>
        <div class="input-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Escribe tu contraseña" required>
        </div>
        <input type="hidden" name="accessibility" value="<?php echo $_SESSION['accessibility'] ?>">
        <input type="submit" value="Iniciar Sesión" tabindex="0">
    </form>
    <div class="volver-container">
        <a href="index.php?accion=paginaPrincipal" id="botonVolver">volver</a>
    </div>
</div>
</body>
</html>
