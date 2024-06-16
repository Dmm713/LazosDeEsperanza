<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Testimonios</title>
    <link rel="stylesheet" href="web/css/estilosVerTodosLosTestimoniosAdmin.css">
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
                <h1>Lista de Testimonios</h1>
            </div>
            <div class="new-user-container">
                <a href="index.php?accion=crearTestimonioAdmin" class="btn btn-primary">Insertar Nuevo Testimonio</a>
                <a href="index.php?accion=paginaPrincipal" class="btn btn-primary"><i class="fa-solid fa-left-long"></i></a>
            </div>
        </div>
    </header>
    <main>
        <?php if (!empty($testimonios)) : ?>
            <div class="testimony-container">
                <?php foreach ($testimonios as $testimonio): ?>
                    <div class="testimony-card">
                        <img src="web/fotosTestimonios/<?php echo $testimonio->getFoto(); ?>" alt="Testimonio" class="testimony-image">
                        <div class="testimony-content">
                            <h2><?php echo $testimonio->getNombre() . ' ' . $testimonio->getApellidos(); ?></h2>
                            <p><strong>Problema:</strong> <?php echo $testimonio->getProblema(); ?></p>
                            <p><strong>Solución:</strong> <?php echo $testimonio->getSolucion(); ?></p>
                            <a href="index.php?accion=editarTestimonioAdmin&idTestimonio=<?php echo $testimonio->getIdTestimonio(); ?>" class="btn-edit">Editar</a>
                            <a href="#" class="btn-delete" onclick="openModal(<?php echo $testimonio->getIdTestimonio(); ?>)">Borrar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p>No hay testimonios disponibles.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Mi Organización</p>
    </footer>

    <!-- Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>¿Está seguro de que desea borrar este testimonio?</p>
            <button id="confirmDelete" class="btn">Confirmar</button>
            <button class="btn" onclick="closeModal()">Cancelar</button>
        </div>
    </div>

    <script>
        let deleteTestimonyId = null;

        function openModal(testimonyId) {
            deleteTestimonyId = testimonyId;
            document.getElementById('deleteModal').style.display = 'block';
        }

        function closeModal() {
            deleteTestimonyId = null;
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteTestimonyId !== null) {
                window.location.href = `index.php?accion=borrarTestimonioAdmin&idTestimonio=${deleteTestimonyId}`;
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