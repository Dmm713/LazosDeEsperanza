<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Proyectos</title>
    <link rel="stylesheet" href="web/css/estilosVerTodosLosProyectosAdmin.css">
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
                <h1>Lista de Proyectos</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=crearProyectoAdmin" class="btn btn-primary">Insertar Nuevo Proyecto</a>
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($proyectos)) : ?>
            <div class="project-container">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="project-card">
                        <img src="web/fotosProyectos/<?php echo $proyecto->getFotoProyecto(); ?>" alt="Proyecto" class="project-image">
                        <div class="project-content">
                            <h2><?php echo $proyecto->getTitulo(); ?></h2>
                            <p><?php echo $proyecto->getDescripcion(); ?></p>
                            <p><strong>Fecha Inicio:</strong> <?php echo $proyecto->getFechaInicio(); ?></p>
                            <p><strong>Fecha Fin:</strong> <?php echo $proyecto->getFechaFin(); ?></p>
                            <p><strong>Objetivo Financiero:</strong> <?php echo $proyecto->getObjetivoFinanciero(); ?></p>
                            <a href="index.php?accion=editarProyectoAdmin&idProyecto=<?php echo $proyecto->getIdProyecto(); ?>" class="btn-edit">Editar</a>
                            <a href="#" class="btn-delete" onclick="openModal(<?php echo $proyecto->getIdProyecto(); ?>)">Borrar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay proyectos disponibles.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Mi Organización</p>
    </footer>

    <!-- Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>¿Está seguro de que desea borrar este proyecto?</p>
            <button id="confirmDelete" class="btn">Confirmar</button>
            <button class="btn" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>
        let deleteProjectId = null;

        function openModal(projectId) {
            deleteProjectId = projectId;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            deleteProjectId = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteProjectId !== null) {
                window.location.href = `index.php?accion=borrarProyectoAdmin&idProyecto=${deleteProjectId}`;
            }
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal();
            }
        }
    </script>
</body>

</html>
