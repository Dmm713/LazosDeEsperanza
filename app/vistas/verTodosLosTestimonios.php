<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Testimonios</title>
    <link rel="stylesheet" href="web/css/estilosVerTodosLosTestimonios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
    </style>
</head>

<body>
<?php if (isset($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const message = "<?php echo $_SESSION['message']; ?>";
            alert(message);
            <?php unset($_SESSION['message']); ?>
        });
    </script>
<?php endif; ?>


    <div class="wrapper">
        <header>
            <div class="header-content">
                <div class="logo-container">
                    <img src="web/Images/lazos de esperanza Blanco.png" alt="Logo" class="logo">
                </div>
                <div class="title-container">
                    <h1>Lista de Testimonios</h1>
                </div>
                <div class="new-user-container">
                    <a href="index.php?accion=paginaPrincipal" class="btn volver" style="background-color: #014949; color: #7FF9B9; margin-right: 25px; width: 30%;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </header>
        <main>
            <?php if (!empty($testimonios)) : ?>
                <div class="testimonio-container">
                    <?php foreach ($testimonios as $testimonio) : ?>
                        <div class="testimonio-card">
                            <div class="testimonio-image-container">
                                <?php if ($testimonio->getFoto()) : ?>
                                    <img src="web/fotosTestimonios/<?php echo htmlspecialchars($testimonio->getFoto()); ?>" alt="Foto del testimonio" class="testimonio-image">
                                <?php else : ?>
                                    <img src="web/images/default-project.png" alt="Foto del testimonio" class="testimonio-image">
                                <?php endif; ?>
                            </div>
                            <div class="testimonio-content">
                                <h2><?php echo htmlspecialchars($testimonio->getNombre()) . ' ' . htmlspecialchars($testimonio->getApellidos()); ?></h2>
                                <p><strong>Problema:</strong> <?php echo htmlspecialchars($testimonio->getProblema()); ?></p>
                                <p><strong>Solución:</strong> <?php echo htmlspecialchars($testimonio->getSolucion()); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No hay testimonios disponibles.</p>
            <?php endif; ?>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Lazos De Esperanza</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
