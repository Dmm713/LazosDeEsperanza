<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos</title>
    <link rel="stylesheet" href="web/css/estilosMisProyectos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>
 
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Lazos de Esperanza" class="logo">
                </div>
                <div class="title-container">
                    <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
                </div>
                <div class="new-user-container">
                    <a href="index.php?accion=crearProyecto" class="btn btn-primary">Crear Nuevo Proyecto</a>
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <h1 style="margin-top: 3%;">Mis Proyectos</h1>
    <ul class="event-list">
        <?php foreach ($proyectos as $proyecto) : ?>
            <li class="event-item">
                <?php if (!empty($proyecto->getFotoProyecto())) : ?>
                    <div class="image-container">
                        <img src="web/fotosProyectos/<?php echo htmlspecialchars($proyecto->getFotoProyecto()); ?>" alt="Foto del proyecto" class="event-image">
                    </div>
                <?php endif; ?>
                <div class="event-details">
                    <strong><?php echo htmlspecialchars($proyecto->getTitulo()); ?></strong><br>
                    <?php echo htmlspecialchars($proyecto->getDescripcion()); ?><br>
                    <strong>Fecha Inicio:</strong> <?php echo htmlspecialchars($proyecto->getFechaInicio()); ?><br>
                    <strong>Fecha Fin:</strong> <?php echo htmlspecialchars($proyecto->getFechaFin()); ?><br>
                    <strong>Objetivo Financiero:</strong> <?php echo htmlspecialchars($proyecto->getObjetivoFinanciero()); ?>€
                </div>
                <div class="event-actions btn-group">
                    <a href="index.php?accion=editarEvento&idEvento=<?php echo $proyecto->getIdProyecto(); ?>">Editar</a>
                    <a href="index.php?accion=borrarEvento&idEvento=<?php echo $proyecto->getIdProyecto(); ?>" class="btn-delete">Eliminar</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <div id="custom-confirm" class="custom-confirm">
        <div class="confirm-box">
            <p>¿Está seguro que desea borrar el proyecto?</p>
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
