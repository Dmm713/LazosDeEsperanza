<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donaciones de la Organización</title>
    <link rel="stylesheet" href="web/css/estilosDonacionesOrganizacion.css">
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
                <h1>Donaciones de la Organización</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main> 
        <div class="total-recaudado">
            <h2>Total Recaudado: <?php echo htmlspecialchars($totalRecaudado); ?>€</h2>
        </div>
        <?php if (!empty($donaciones)) : ?>
            <div class="donacion-container">
                <?php foreach ($donaciones as $donacion) : ?>
                    <div class="donacion-card">
                        <?php if ($donacion['fotoProyecto']) : ?>
                            <img src="web/fotosProyectos/<?php echo htmlspecialchars($donacion['fotoProyecto']); ?>" alt="Foto del proyecto" class="donacion-image">
                        <?php else : ?>
                            <img src="web/images/default-project.png" alt="Foto del proyecto" class="donacion-image">
                        <?php endif; ?>
                        <div class="donacion-content">
                            <h2><?php echo htmlspecialchars($donacion['nombreProyecto']); ?></h2>
                            <p><?php echo htmlspecialchars($donacion['descripcionProyecto']); ?></p>
                            <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($donacion['cantidad']); ?></p>
                            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($donacion['fecha']); ?></p>
                            <a href="javascript:void(0);" class="delete-button" onclick="showConfirmationModal(<?php echo htmlspecialchars($donacion['idDonacion']); ?>)"><i class="fas fa-times-circle"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="no-donaciones">
                <p>No se han realizado donaciones a tus proyectos.</p>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Mi Organización</p>
    </footer>

    <!-- Modal de confirmación -->
    <div id="confirmationModal" class="dialog-overlay">
        <div class="dialog-box">
            <span class="close" onclick="closeConfirmationModal()">&times;</span>
            <p>¿Estás seguro de que deseas borrar esta donación?</p>
            <div class="dialog-buttons">
                <button id="confirmButton" class="confirm-btn">Confirmar</button>
                <button class="cancel-btn" onclick="closeConfirmationModal()">Cancelar</button>
            </div>
        </div>
    </div>

    <script>
        let idDonacionToDelete = null;

        function showConfirmationModal(idDonacion) {
            idDonacionToDelete = idDonacion;
            document.getElementById('confirmationModal').style.display = 'flex';
        }

        function closeConfirmationModal() {
            document.getElementById('confirmationModal').style.display = 'none';
            idDonacionToDelete = null;
        }

        document.getElementById('confirmButton').onclick = function () {
            if (idDonacionToDelete) {
                window.location.href = "index.php?accion=borrarDonacion&idDonacion=" + idDonacionToDelete;
            }
        }
    </script>
</body>

</html>
