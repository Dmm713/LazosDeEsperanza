<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Testimonios</title>
    <link rel="stylesheet" href="web/css/estilosMisTestimonios.css">
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
                    <h1 style="color: white;"><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
                </div>
                <div class="new-user-container">
                    <a href="index.php?accion=crearTestimonio" class="btn btn-primary">Crear Nuevo Testimonio</a>
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <h1 style="margin-top: 3%;">Mis Testimonios</h1>
    <div class="testimonio-grid">
        <?php foreach ($testimonios as $testimonio) : ?>
            <div class="testimonio-card">
                <?php if (!empty($testimonio->getFoto())) : ?>
                    <div class="testimonio-image-container">
                        <img src="web/fotosTestimonios/<?php echo htmlspecialchars($testimonio->getFoto()); ?>" alt="Foto del testimonio" class="testimonio-image">
                    </div>
                <?php endif; ?>
                <div class="testimonio-content">
                    <h2><?php echo htmlspecialchars($testimonio->getNombre() . ' ' . htmlspecialchars($testimonio->getApellidos())); ?></h2>
                    <p><strong>Problema:</strong> <?php echo htmlspecialchars($testimonio->getProblema()); ?></p>
                    <p><strong>Solución:</strong> <?php echo htmlspecialchars($testimonio->getSolucion()); ?></p>
                    <div class="testimonio-actions">
                        <a href="index.php?accion=editarTestimonio&idTestimonio=<?php echo $testimonio->getIdTestimonio(); ?>" class="btn-edit">Editar</a>
                        <a href="index.php?accion=borrarTestimonio&idTestimonio=<?php echo $testimonio->getIdTestimonio(); ?>" class="btn-delete">Eliminar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="custom-confirm" class="custom-confirm">
        <div class="confirm-box">
            <p>¿Está seguro que desea borrar el testimonio?</p>
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
