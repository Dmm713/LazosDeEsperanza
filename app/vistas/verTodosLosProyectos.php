<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Proyectos</title>
    <link rel="stylesheet" href="web/css/estilosVerTodosLosProyectos.css">
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
                    <h1>Lista de Proyectos</h1>
                </div>
                <div class="new-user-container">
                    <a href="index.php?accion=paginaPrincipal" class="btn volver" style="background-color: #014949; color: #7FF9B9; margin-right: 25px; width: 30%;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </header>
        <main>
            <?php
            // Inicializa $proyectosVoluntarios como un array vacío
            $proyectosVoluntarios = [];
            
            // Verifica si el usuario tiene proyectos de voluntariado
            if (isset($_SESSION['idUsuario'])) {
                $voluntariados = (new VoluntariosDAO($conn))->getVoluntariadosByUsuario($_SESSION['idUsuario']);
                $proyectosVoluntarios = array_column($voluntariados, 'idProyecto');
            }
            ?>

            <?php if (!empty($proyectos)) : ?>
                <div class="project-container">
                    <?php foreach ($proyectos as $proyecto) : ?>
                        <div class="project-card" data-idproyecto="<?php echo htmlspecialchars($proyecto->getIdProyecto()); ?>">
                            <div class="project-image-container">
                                <?php if ($proyecto->getFotoProyecto()) : ?>
                                    <img src="web/fotosProyectos/<?php echo htmlspecialchars($proyecto->getFotoProyecto()); ?>" alt="Foto del proyecto" class="project-image">
                                <?php else : ?>
                                    <img src="web/images/default-project.png" alt="Foto del proyecto" class="project-image">
                                <?php endif; ?>
                            </div>
                            <div class="project-content">
                                <div class="project-header">
                                    <h2><?php echo htmlspecialchars($proyecto->getTitulo()); ?></h2>
                                </div>
                                <div class="project-body">
                                    <p><?php echo htmlspecialchars($proyecto->getDescripcion()); ?></p>
                                    <p><strong>Fecha de Inicio:</strong> <?php echo htmlspecialchars($proyecto->getFechaInicio()); ?></p>
                                    <p><strong>Fecha de Fin:</strong> <?php echo htmlspecialchars($proyecto->getFechaFin()); ?></p>
                                    <p><strong>Objetivo Financiero:</strong> <?php echo htmlspecialchars($proyecto->getObjetivoFinanciero()); ?></p>
                                </div>
                                <div class="project-footer">
                                    <button class="btn btn-primary" style="background-color: #014949; color: #7FF9B9; border-color: #014949;" data-bs-toggle="modal" data-bs-target="#donacionModal" data-idproyecto="<?php echo htmlspecialchars($proyecto->getIdProyecto()); ?>">Donar</button>
                                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Usuario') : ?>
                                        <?php if (in_array($proyecto->getIdProyecto(), $proyectosVoluntarios)) : ?>
                                            <button class="btn btn-secondary" disabled>Ya está apuntado como voluntario</button>
                                        <?php else : ?>
                                            <button class="btn btn-primary" style="background-color: #014949; color: #7FF9B9; border-color: #014949;" data-bs-toggle="modal" data-bs-target="#voluntariadoModal" data-fechainicio="<?php echo htmlspecialchars($proyecto->getFechaInicio()); ?>" data-fechafin="<?php echo htmlspecialchars($proyecto->getFechaFin()); ?>">Hacer Voluntariado</button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No hay proyectos disponibles.</p>
            <?php endif; ?>
        </main>
    </div>
    <footer>
        <p>&copy; 2024 Lazos De Esperanza</p>
    </footer>
<!-- Modal para hacer voluntariado -->
<div class="modal fade custom-modal" id="voluntariadoModal" tabindex="-1" aria-labelledby="voluntariadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voluntariadoModalLabel">Inscribirse en Voluntariado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="voluntariadoForm" method="post" action="index.php?accion=inscribirseVoluntariadoTodosProyectos">
                    <div class="mb-3">
                        <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fechaFin" class="form-label">Fecha Fin</label>
                        <input type="date" class="form-control" id="fechaFin" name="fechaFin" readonly>
                    </div>
                    <input type="hidden" id="idProyecto" name="idProyecto">
                    <input type="hidden" id="returnUrl" name="returnUrl" value="index.php?accion=verTodosLosProyectos">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Inscribirse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Modal para donaciones -->
    <div class="modal fade custom-modal" id="donacionModal" tabindex="-1" aria-labelledby="donacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donacionModalLabel">Realizar Donación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donacionForm" method="post" action="index.php?accion=procesarDonacion">
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="numeroTarjeta" class="form-label">Número de Tarjeta</label>
                            <input type="text" class="form-control" id="numeroTarjeta" name="numeroTarjeta" required>
                        </div>
                        <div class="mb-3">
                            <label for="mes" class="form-label">Mes</label>
                            <input type="text" class="form-control" id="mes" name="mes" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Año</label>
                            <input type="text" class="form-control" id="year" name="year" required>
                        </div>
                        <div class="mb-3">
                            <label for="ccv" class="form-label">CCV</label>
                            <input type="text" class="form-control" id="ccv" name="ccv" required>
                        </div>
                        <input type="hidden" id="idProyecto" name="idProyecto">
                        <input type="hidden" id="returnUrl" name="returnUrl" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Donar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const donacionModal = document.getElementById('donacionModal');
            donacionModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const idProyecto = button.getAttribute('data-idproyecto');
                const idProyectoInput = donacionModal.querySelector('#idProyecto');
                idProyectoInput.value = idProyecto;
            });

            const voluntariadoModal = document.getElementById('voluntariadoModal');
            voluntariadoModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const fechaInicio = button.getAttribute('data-fechainicio');
                const fechaFin = button.getAttribute('data-fechafin');
                const idProyecto = button.closest('.project-card').getAttribute('data-idproyecto');

                const fechaInicioInput = voluntariadoModal.querySelector('#fechaInicio');
                const fechaFinInput = voluntariadoModal.querySelector('#fechaFin');
                const idProyectoInput = voluntariadoModal.querySelector('#idProyecto');

                fechaInicioInput.value = fechaInicio;
                fechaFinInput.value = fechaFin;
                idProyectoInput.value = idProyecto;
            });
        });
    </script>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = "<?php echo $_SESSION['accessibility'] ?>"
                console.log(accessibility)
                if (accessibility === 'yes') {
                    var elementos = document.querySelectorAll('h1, h5, h3, h2, p, a, button , label, input, strong, ul, li, textarea');

                    function agregarEventos(elemento) {
                        elemento.addEventListener("mouseover", function(event) {
                            hablarTexto(event.target.innerText);
                        });

                        elemento.addEventListener("mouseout", function() {
                            detenerTexto();
                        });

                        elemento.addEventListener("focus", function(event) {
                            hablarTexto(event.target.innerText);
                        });

                        elemento.addEventListener("blur", function() {
                            detenerTexto();
                        });
                    }

                    elementos.forEach(agregarEventos);

                    function hablarTexto(texto) {
                        var voz = new SpeechSynthesisUtterance();
                        voz.text = texto;
                        window.speechSynthesis.speak(voz);
                    }

                    function detenerTexto() {
                        window.speechSynthesis.cancel();
                    }
                }
            });

            document.addEventListener("DOMContentLoaded", function() {
                const urlParams = new URLSearchParams(window.location.search);
                const accessibility = urlParams.get('accessibility');
                const registerLink = document.getElementById('linkRegistrar');

                if (accessibility) {
                    registerLink.href += '&accessibility=' + accessibility;
                }
            });
        </script>
</body>

</html>
