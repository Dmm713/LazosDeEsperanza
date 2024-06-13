<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($organizacion->getNombre()); ?></title>
    <link rel="stylesheet" href="web/css/estilosPaginaOrganizacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&display=swap');
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
                    <a href="index.php?accion=paginaPrincipal" class="btn btn-primary volver"><i class="fa-solid fa-left-long"></i></a>
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
                foreach ($proyectos as $proyecto) {
                    echo "<div class='proyecto'>
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
                        echo "<div class='proyecto-footer boton-voluntariado'>
                                <a href='index.php?accion=hacerVoluntariado&idProyecto=" . htmlspecialchars($proyecto->getIdProyecto()) . "' class='btn btn-primary'>Hacer Voluntariado</a>
                              </div>";
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
                    <p class="card-text"><strong>Problema:</strong>  <?php echo htmlspecialchars($testimonio->getProblema()); ?></p>
                    <p class="card-text"><strong>Solución:</strong>  <?php echo htmlspecialchars($testimonio->getSolucion()); ?></p>
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
</body>

</html>
