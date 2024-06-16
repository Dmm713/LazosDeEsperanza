<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Eventos</title>
    <link rel="stylesheet" href="web/css/estilosVerTodosLosEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="web/Images/lazos de esperanza Blanco.png" alt="Logo" class="logo">
            </div>
            <div class="title-container">
                <h1>Lista de Eventos</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($eventos)) : ?>
            <div class="event-container">
                <?php foreach ($eventos as $evento) : ?>
                    <div class="event-card">
                        <?php if ($evento->getFotoEvento()) : ?>
                            <img src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento" class="event-image">
                        <?php else : ?>
                            <img src="web/images/default-event.png" alt="Foto del evento" class="event-image">
                        <?php endif; ?>
                        <div class="event-content">
                            <h2><?php echo htmlspecialchars($evento->getTitulo()); ?></h2>
                            <p><?php echo htmlspecialchars($evento->getDescripcion()); ?></p>
                            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($evento->getFechaEvento()); ?></p>
                            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento->getUbicacion()); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay eventos disponibles.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Mi Organización</p>
    </footer>
</body>

</html>
