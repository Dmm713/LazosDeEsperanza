<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos</title>
    <link rel="stylesheet" href="web/css/estilosMisEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
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
                    <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
                </div>
                <!-- Botón para insertar un nuevo usuario -->
                <div class="new-user-container">
                    <a href="index.php?accion=crearEvento" class="btn btn-primary">Crear Nuevo Evento</a>
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <h1 style="margin-top: 3%;">Mis Eventos</h1>
    <ul class="event-list">
        <?php foreach ($eventos as $evento) : ?>
            <li class="event-item">
                <?php if (!empty($evento->getFotoEvento())) : ?>
                    <img src="web/fotosEventos/<?php echo htmlspecialchars($evento->getFotoEvento()); ?>" alt="Foto del evento" class="event-image">
                <?php endif; ?>
                <div class="event-details">
                    <strong><?php echo htmlspecialchars($evento->getTitulo()); ?></strong><br>
                    <?php echo htmlspecialchars($evento->getDescripcion()); ?><br>
                    Fecha: <?php echo htmlspecialchars($evento->getFechaEvento()); ?><br>
                    Ubicación: <?php echo htmlspecialchars($evento->getUbicacion()); ?>
                </div>
                <div class="event-actions btn-group">
                    <a href="index.php?accion=editarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>">Editar</a>
                    <a href="index.php?accion=borrarEvento&idEvento=<?php echo $evento->getIdEvento(); ?>" class="btn-delete">Eliminar</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <div id="custom-confirm" class="custom-confirm">
        <div class="confirm-box">
            <p>¿Está seguro que desea borrar el evento?</p>
            <div class="btn-container">
                <button id="confirm-yes" class="btn">Sí</button>
                <button id="confirm-no" class="btn">No</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');
            const confirmBox = document.getElementById('custom-confirm');
            const confirmYes = document.getElementById('confirm-yes');
            const confirmNo = document.getElementById('confirm-no');
            let currentLink = null;

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    currentLink = this.href;
                    confirmBox.style.display = 'flex';
                });
            });

            confirmYes.addEventListener('click', function() {
                if (currentLink) {
                    window.location.href = currentLink;
                }
            });

            confirmNo.addEventListener('click', function() {
                confirmBox.style.display = 'none';
                currentLink = null;
            });
        });
    </script>
</body>

</html>