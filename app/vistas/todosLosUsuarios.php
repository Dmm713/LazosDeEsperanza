<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos Los Usuarios</title>
    <link rel="stylesheet" href="web/css/estilosTodosLosUsuarios.css">
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
                <h1>TODOS LOS USUARIOS</h1>
            </div>
            <!-- Botón para insertar un nuevo usuario -->
            <div class="new-user-container">
                <a href="index.php?accion=nuevoUsuario" class="btn btn-primary">Insertar Nuevo Usuario</a>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <?php foreach ($usuarios as $usuario) : ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="web/fotosUsuarios/<?= htmlspecialchars($usuario->getFoto()) ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3><?= htmlspecialchars($usuario->getNombre()) ?></h3>
                        <p><?= htmlspecialchars($usuario->getApellidos()) ?></p>
                        <div class="btn-group">
                            <a href="index.php?accion=editarUsuario&idUsuario=<?=$usuario->getIdUsuario()?>" class="btn btn-primary">Editar</a>
                            <a href="index.php?accion=borrarUsuario&idUsuario=<?=$usuario->getIdUsuario()?>" class="btn btn-primary">Borrar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Botón para volver -->
    <div class="return-container">
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </div>
</div>

</body>
</html>
