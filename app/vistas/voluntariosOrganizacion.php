<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voluntarios de la Organización</title>
    <link rel="stylesheet" href="web/css/estilosVoluntariosOrganizacion.css">
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
                <h1>Voluntarios de la Organización</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($voluntarios)) : ?>
            <div class="voluntario-container">
                <?php foreach ($voluntarios as $voluntario) : ?>
                    <div class="voluntario-card">
                        <button class="btn-delete" onclick="mostrarDialogo(<?php echo $voluntario['idVoluntario']; ?>)">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                        <?php if ($voluntario['fotoProyecto']) : ?>
                            <img src="web/fotosProyectos/<?php echo htmlspecialchars($voluntario['fotoProyecto']); ?>" alt="Foto del proyecto" class="voluntario-image">
                        <?php else : ?>
                            <img src="web/images/default-project.png" alt="Foto del proyecto" class="voluntario-image">
                        <?php endif; ?>
                        <div class="voluntario-content">
                            <h2><?php echo htmlspecialchars($voluntario['nombreUsuario'] . ' ' . $voluntario['apellidosUsuario']); ?></h2>
                            <p><strong>Correo:</strong> <?php echo htmlspecialchars($voluntario['emailUsuario']); ?></p>
                            <h2>Proyecto</h2>
                            <h3><?php echo htmlspecialchars($voluntario['nombreProyecto']); ?></h3>
                            <p><?php echo htmlspecialchars($voluntario['descripcionProyecto']); ?></p>
                            <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($voluntario['fechaInicio']); ?></p>
                            <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($voluntario['fechaFin']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="no-voluntarios">
                <p>No hay voluntarios registrados en tus proyectos.</p>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Lazos De Esperenza</p>
    </footer>

    <!-- Cuadro de diálogo -->
    <div id="dialog-overlay" class="dialog-overlay">
        <div class="dialog-box">
            <p>¿Estás seguro de que deseas eliminar a este voluntario?</p>
            <div class="dialog-buttons">
                <button class="confirm-btn" onclick="confirmarEliminacion()">Confirmar</button>
                <button class="cancel-btn" onclick="cerrarDialogo()">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        let voluntarioAEliminar = null;

        function mostrarDialogo(idVoluntario) {
            voluntarioAEliminar = idVoluntario;
            document.getElementById('dialog-overlay').style.display = 'flex';
        }

        function cerrarDialogo() {
            document.getElementById('dialog-overlay').style.display = 'none';
            voluntarioAEliminar = null;
        }

        function confirmarEliminacion() {
            if (voluntarioAEliminar !== null) {
                window.location.href = 'index.php?accion=borrarVoluntario&idVoluntario=' + voluntarioAEliminar;
            }
        }
    </script>
</body>

</html>
