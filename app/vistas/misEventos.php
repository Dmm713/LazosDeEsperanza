<!DOCTYPE html>
<html>
<head>
    <title>Página de Organización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #08929c;
        }
        .event-list {
            list-style-type: none;
            padding: 0;
            max-width: 800px;
            margin: 0 auto;
        }
        .event-item {
            display: flex;
            align-items: center;
            background-color: #fff;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .event-image {
            max-width: 150px;
            height: auto;
            margin-right: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .event-details {
            flex: 1;
        }
        .event-details strong {
            font-size: 1.2em;
            color: #08929c;
        }
        .event-actions {
            display: flex;
            flex-direction: column;
            margin-left: 20px;
        }
        .event-actions a {
            margin: 5px 0;
            padding: 5px 10px;
            background-color: #08929c;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9em;
            cursor: pointer;
        }
        .event-actions a:hover {
            background-color: #067a83;
        }
        .btn {
            display: block;
            width: fit-content;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #08929c;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #067a83;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
    <h2>Eventos</h2>
    <ul class="event-list">
        <?php foreach ($eventos as $evento): ?>
            <li class="event-item">
                <?php if (!empty($evento->getFotoEvento())): ?>
                    <img src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento" class="event-image">
                <?php endif; ?>
                <div class="event-details">
                    <strong><?php echo htmlspecialchars($evento->getTitulo()); ?></strong><br>
                    <?php echo htmlspecialchars($evento->getDescripcion()); ?><br>
                    Fecha: <?php echo htmlspecialchars($evento->getFechaEvento()); ?><br>
                    Ubicación: <?php echo htmlspecialchars($evento->getUbicacion()); ?>
                </div>
                <div class="event-actions">
                    <a href="index.php?accion=editarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>">Editar</a>
                    <a href="index.php?accion=eliminarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este evento?');">Eliminar</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?accion=crearEvento" class="btn">Crear Nuevo Evento</a>
    <a href="index.php?accion=paginaOrganizacion&idOrganizacion=<?php echo $organizacion->getIdOrganizacion(); ?>" class="btn">Volver</a>
</body>
</html>
