<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($organizacion->getNombre()); ?></title>
    <link rel="stylesheet" href="web/css/estilosPaginaOrganizacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            color: #333;
            margin: 0;
        }
    </style>
</head>

<body>
    <?php
    $rol = isset($_GET['rol']) ? $_GET['rol'] : '';
    ?>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <img src="web/logosOrganizaciones/<?= htmlspecialchars($organizacion->getLogo()) ?>" alt="Logo" class="logo">
                </div>
                <div class="title-container">
                    <h1><?php echo htmlspecialchars($organizacion->getNombre()); ?></h1>
                </div>
                <div class="new-user-container">
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary volver" style="background-color: #014949; color: #7FF9B9; border-color: #014949;">Donar</a>
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary volver" style="background-color: #014949; color: #7FF9B9; border-color: #014949;"><i class="fa-solid fa-left-long"></i></a>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="sobreNosotros">
            <section class="mission-vision-values">
                <div class="content-wrapper">
                    <img src="web/fotosUsuarios/<?= htmlspecialchars($organizacion->getFoto()) ?>" alt="Foto Fundación" class="vision-img">
                    <div class="vision">
                        <h2>Quiénes Somos</h2>
                        <p><?php echo htmlspecialchars($organizacion->getQuienesSomos()); ?></p>
                    </div>
                </div>
            </section>

            <section class="mission-vision-values">
                <div class="content-wrapper">
                    <div class="vision objetivos">
                        <h2>Objetivos</h2>
                        <p><?php echo htmlspecialchars($organizacion->getObjetivos()); ?></p>
                    </div>
                    <div class="vision">
                        <h2>Ciudades</h2>
                        <p><?php echo htmlspecialchars($organizacion->getCiudades()); ?></p>
                    </div>
                </div>
            </section>
        </div>
        <div class="events">
            <h2>Eventos</h2>
            <div class="event-container">
                <?php
                $eventos = (new EventosDAO($conn))->getEventosByOrganizacion($organizacion->getIdOrganizacion());
                foreach ($eventos as $evento) {
                    echo "<div class='event'>
                            <img src='web/fotosEventos/" . htmlspecialchars($evento->getFotoEvento()) . "' alt='Foto del evento' class='event-image'>
                            <div class='event-content'>
                                <h3>" . htmlspecialchars($evento->getTitulo()) . "</h3>
                                <p>" . htmlspecialchars($evento->getDescripcion()) . "</p>
                                <div class='event-footer'>
                                    <strong>Fecha:</strong>
                                    <span>" . htmlspecialchars($evento->getFechaEvento()) . "</span>
                                </div>
                            </div>
                          </div>";
                }
                ?>
            </div>
        </div>

        <div class="proyectos">
            <h2>Proyectos</h2>
            <div class="proyecto-container">
                <?php
                $proyectos = (new ProyectosDAO($conn))->getProyectosByOrganizacion($organizacion->getIdOrganizacion());
                $proyectosVoluntarios = array_column($voluntariados, 'idProyecto');
                foreach ($proyectos as $proyecto) {
                    echo "<div class='proyecto' data-idproyecto='" . htmlspecialchars($proyecto->getIdProyecto()) . "'>
                    <img src='web/fotosProyectos/" . htmlspecialchars($proyecto->getFotoProyecto()) . "' alt='Foto del proyecto' class='proyecto-image'>
                    <div class='proyecto-content'>
                        <h3>" . htmlspecialchars($proyecto->getTitulo()) . "</h3>
                        <p>" . htmlspecialchars($proyecto->getDescripcion()) . "</p>
                        <div class='proyecto-footer'>
                            <strong>Fecha Inicio:</strong>
                            <span>" . htmlspecialchars($proyecto->getFechaInicio()) . "</span>
                        </div>
                        <div class='proyecto-footer'>
                            <strong>Fecha Fin:</strong>
                            <span>" . htmlspecialchars($proyecto->getFechaFin()) . "</span>
                        </div>
                        <div class='proyecto-footer'>
                            <strong>Objetivo Financiero:</strong>
                            <span>" . htmlspecialchars($proyecto->getObjetivoFinanciero()) . "</span>
                        </div>";
                    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Usuario') {
                        if (in_array($proyecto->getIdProyecto(), $proyectosVoluntarios)) {
                            echo "<div class='proyecto-footer boton-voluntariado'>
                            <button class='btn btn-secondary' disabled>Ya está apuntado como voluntario</button>
                          </div>";
                        } else {
                            echo "<div class='proyecto-footer boton-voluntariado'>
                            <button class='btn btn-primary' style='background-color: #014949; color: #7FF9B9; border-color: #014949;' data-bs-toggle='modal' data-bs-target='#voluntariadoModal' data-fechainicio='" . htmlspecialchars($proyecto->getFechaInicio()) . "' data-fechafin='" . htmlspecialchars($proyecto->getFechaFin()) . "'>Hacer Voluntariado</button>
                          </div>";
                        }
                    }
                    echo "</div></div>";
                }
                ?>
            </div>
        </div>

        <div class="cards-container">
            <h2>Testimonios</h2>
            <div class="owl-carousel owl-carousel1 owl-theme">
                <?php foreach ($testimonios as $index => $testimonio) : ?>
                    <div>
                        <div class="card text-center">
                            <div class="image-container">
                                <img src="web/fotosTestimonios/<?php echo htmlspecialchars($testimonio->getFoto()); ?>" alt="Foto de <?php echo htmlspecialchars($testimonio->getNombre()); ?>">
                            </div>
                            <div class="card-body">
                                <h5><?php echo htmlspecialchars($testimonio->getNombre() . ' ' . $testimonio->getApellidos()); ?><br /></h5>
                                <p class="card-text"><strong>Problema:</strong> <?php echo htmlspecialchars($testimonio->getProblema()); ?></p>
                                <p class="card-text"><strong>Solución:</strong> <?php echo htmlspecialchars($testimonio->getSolucion()); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <footer class="footer">
        <img src="web/logosOrganizaciones/<?= htmlspecialchars($organizacion->getLogo()) ?>" alt="Logo" class="logo">
        <p><strong>Contacto:</strong> <?php echo htmlspecialchars($organizacion->getTelefono()); ?>, <?php echo htmlspecialchars($organizacion->getEmail()); ?></p>
        <p><?php echo htmlspecialchars($organizacion->getDireccion()); ?></p>
        <p>Copyright © 2024</p>
    </footer>

    <!-- Modal para hacer voluntariado -->
    <div class="modal fade" id="voluntariadoModal" tabindex="-1" aria-labelledby="voluntariadoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="voluntariadoModalLabel">Inscribirse en Voluntariado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="voluntariadoForm" method="post" action="index.php?accion=inscribirseVoluntariado">
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="fechaFin" class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fechaFin" name="fechaFin" readonly>
                        </div>
                        <input type="hidden" id="idProyecto" name="idProyecto">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Inscribirse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const voluntariadoModal = document.getElementById('voluntariadoModal');
            voluntariadoModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const fechaInicio = button.getAttribute('data-fechainicio');
                const fechaFin = button.getAttribute('data-fechafin');
                const idProyecto = button.closest('.proyecto').getAttribute('data-idproyecto');

                const fechaInicioInput = voluntariadoModal.querySelector('#fechaInicio');
                const fechaFinInput = voluntariadoModal.querySelector('#fechaFin');
                const idProyectoInput = voluntariadoModal.querySelector('#idProyecto');

                fechaInicioInput.value = fechaInicio;
                fechaFinInput.value = fechaFin;
                idProyectoInput.value = idProyecto;
            });
        });
    </script>
</body>

</html>
