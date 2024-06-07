<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($organizacion->getNombre()); ?></title>
    <link rel="stylesheet" href="estilosPaginaOrganización.css">
    
</head>
<body>
    <header>
        
    </header>
    <div class="container">
        <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
        <div class="content">
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($organizacion->getDescripcion()); ?></p>
            <p><strong>Sitio Web:</strong> <a href="<?php echo htmlspecialchars($organizacion->getSitioWeb()); ?>"><?php echo htmlspecialchars($organizacion->getSitioWeb()); ?></a></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($organizacion->getTelefono()); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($organizacion->getEmail()); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($organizacion->getDireccion()); ?></p>
            <p><strong>Foto:</strong> <img src="web/fotosUsuarios/<?php echo htmlspecialchars($organizacion->getFoto()); ?>" alt="Foto de <?php echo htmlspecialchars($organizacion->getNombre()); ?>"></p>
            
            <a href="index.php" class="btn">Volver</a>
        </div>
    </div>
</body>
</html>
