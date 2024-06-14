<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Voluntariados</title>
    <link rel="stylesheet" href="web/css/estilosMisVoluntariados.css">
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
                <h1>Mis Voluntariados</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($voluntariados)) : ?>
            <div class="voluntariado-container">
                <?php foreach ($voluntariados as $voluntariado) : ?>
                    <div class="voluntariado-card">
                        <?php if ($voluntariado['fotoProyecto']) : ?>
                            <img src="web/fotosProyectos/<?php echo htmlspecialchars($voluntariado['fotoProyecto']); ?>" alt="Foto del proyecto" class="voluntariado-image">
                        <?php else : ?>
                            <img src="web/images/default-project.png" alt="Foto del proyecto" class="voluntariado-image">
                        <?php endif; ?>
                        <div class="voluntariado-content">
                            <h2><?php echo htmlspecialchars($voluntariado['nombreProyecto']); ?></h2>
                            <p><?php echo htmlspecialchars($voluntariado['descripcionProyecto']); ?></p>
                            <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($voluntariado['fechaInicio']); ?></p>
                            <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($voluntariado['fechaFin']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="no-voluntariados">
                <p>No estás apuntado a ningún voluntariado.</p>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Mi Organización</p>
    </footer>
</body>

</html>
