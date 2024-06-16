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

        /* Estilos del modal de registro */
        .custom-modal .modal-content {
            background-color: #e0f7fa;
            color: #014949;
        }

        .custom-modal .modal-header,
        .custom-modal .modal-footer {
            border: none;
            background-color: #014949;
            color: #7FF9B9;
        }

        .custom-modal .modal-title {
            color: #7FF9B9;
        }

        .custom-modal .btn-close {
            filter: invert(1);
        }

        .custom-modal .btn-secondary {
            background-color: #014949;
            color: #7FF9B9;
            border: 1px solid #7FF9B9;
        }

        .custom-modal .btn-secondary:hover {
            background-color: #013838;
            color: #7FF9B9;
            border: 1px solid #7FF9B9;
        }
    </style>
</head>

<body>
    <?php
    $rol = isset($_GET['rol']) ? $_GET['rol'] : '';

    // Inicializar $proyectosVoluntarios como un array vacío
    $proyectosVoluntarios = [];

    // Supongamos que tienes una función para obtener los proyectos de voluntariado del usuario actual
    if (isset($_SESSION['idUsuario'])) {
        $voluntariados = (new VoluntariosDAO($conn))->getVoluntariadosByUsuario($_SESSION['idUsuario']);
        $proyectosVoluntarios = array_column($voluntariados, 'idProyecto');
    }
    ?>

    <!-- Cuadro de diálogo para mensajes de donación -->
    <?php if (isset($_SESSION['message'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const message = "<?= $_SESSION['message']; ?>";
                alert(message);
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            });
        </script>
    <?php endif; ?>

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

        <!-- Sección de Eventos -->
        <div class="events">
            <h2>Eventos</h2>
            <div class="event-container">
                <?php
                $eventos = (new EventosDAO($conn))->getEventosByOrganizacion($organizacion->getIdOrganizacion());
                if (empty($eventos)) {
                    echo "<p>Esta organización no tiene ningún evento.</p>";
                } else {
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
                }
                ?>
            </div>
        </div>

        <!-- Sección de Proyectos -->
        <div class="proyectos">
            <h2>Proyectos</h2>
            <div class="proyecto-container">
                <?php
                $proyectos = (new ProyectosDAO($conn))->getProyectosByOrganizacion($organizacion->getIdOrganizacion());
                if (empty($proyectos)) {
                    echo "<p>Esta organización no tiene ningún proyecto.</p>";
                } else {
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
                                </div>
                                <div class='proyecto-footer'>
                                    <button class='btn btn-primary' style='background-color: #014949; color: #7FF9B9; border-color: #014949;' data-bs-toggle='modal' data-bs-target='#donacionModal' data-idproyecto='" . htmlspecialchars($proyecto->getIdProyecto()) . "'>Donar</button>
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
                }
                ?>
            </div>
        </div>

        <!-- Sección de Testimonios -->
        <div class="cards-container">
            <h2>Testimonios</h2>
            <div class="owl-carousel owl-carousel1 owl-theme">
                <?php
                if (empty($testimonios)) {
                    echo "<p>Esta organización no tiene ningún testimonio.</p>";
                } else {
                    foreach ($testimonios as $index => $testimonio) {
                        echo "<div>
                            <div class='card text-center'>
                                <div class='image-container'>
                                    <img src='web/fotosTestimonios/" . htmlspecialchars($testimonio->getFoto()) . "' alt='Foto de " . htmlspecialchars($testimonio->getNombre()) . "'>
                                </div>
                                <div class='card-body'>
                                    <h5>" . htmlspecialchars($testimonio->getNombre() . ' ' . $testimonio->getApellidos()) . "<br /></h5>
                                    <p class='card-text'><strong>Problema:</strong> " . htmlspecialchars($testimonio->getProblema()) . "</p>
                                    <p class='card-text'><strong>Solución:</strong> " . htmlspecialchars($testimonio->getSolucion()) . "</p>
                                </div>
                            </div>
                        </div>";
                    }
                }
                ?>
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

    <!-- Modal para donaciones -->
    <div class="modal fade" id="donacionModal" tabindex="-1" aria-labelledby="donacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content custom-modal">
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

    <!-- Modal para no registrados -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Aviso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Si no estás registrado no puedes donar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const donacionModal = document.getElementById('donacionModal');
            donacionModal.addEventListener('show.bs.modal', function(event) {
                <?php if (!isset($_SESSION['idUsuario'])): ?>
                    const registroModal = new bootstrap.Modal(document.getElementById('registroModal'));
                    registroModal.show();
                    event.preventDefault();
                <?php else: ?>
                    const button = event.relatedTarget;
                    const idProyecto = button.getAttribute('data-idproyecto');
                    const idProyectoInput = donacionModal.querySelector('#idProyecto');
                    idProyectoInput.value = idProyecto;
                <?php endif; ?>
            });

            <?php if (isset($_SESSION['message'])): ?>
                const message = "<?= $_SESSION['message']; ?>";
                alert(message);
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            <?php endif; ?>
        });
    </script>

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
