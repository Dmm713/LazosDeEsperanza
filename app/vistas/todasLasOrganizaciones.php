<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos Los Usuarios</title>
    <link rel="stylesheet" href="web/css/estilosTodosLosUsuarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
                <h1>TODAS LAS ORGANIZACIONES</h1>
            </div>
            <!-- Botón para insertar un nuevo usuario -->
            <div class="new-user-container">
                <a href="index.php?accion=insertarUsuario" class="btn btn-primary">Insertar Nueva Organización</a>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <?php foreach ($organizaciones as $organizacion) : ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="web/fotosUsuarios/<?= htmlspecialchars($organizacion->getFoto()) ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3><?= htmlspecialchars($organizacion->getNombre()) ?></h3>
                        <p><?= htmlspecialchars($organizacion->getDescripcion()) ?></p>
                        <div class="btn-group">
                            <a href="index.php?accion=editarOrganizacion&idOrganizacion=<?=$organizacion->getIdOrganizacion()?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="index.php?accion=borrarOrganizacion&idOrganizacion=<?=$organizacion->getIdOrganizacion()?>" class="btn btn-primary"><i class="fa-solid fa-trash-can" style="color: red;;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Botón para volver -->
    <div class="return-container">
    <a href="index.php?accion=paginaPrincipal" class="btn btn-secondary hover-door"><i class="fa-solid fa-left-long"></i></a>
    </div>
</div>

</body>
</html>
